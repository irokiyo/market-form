<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\ExhibitionRequest;
use App\Http\Requests\CommentRequest;
use App\Http\Requests\PurchaseRequest;
use App\Http\Requests\AddressRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Favorite;
use App\Models\Trade;
use App\Models\Review;
use App\Models\Message;
use Illuminate\Support\Facades\Session;

class ItemController extends Controller
{
    //商品一覧画面（トップ画面）
    public function index(Request $request)
    {
        $tab = $request->query('tab', '');
        $keyword = $request->query('keyword');
        $userId = auth()->id();

        $items = Item::query()
            ->when($userId, fn ($q) => $q->where('user_id', '!=', $userId))
            ->keywordSearch($keyword)
            ->get();

        $favorites = collect();
        if ($tab === 'mylist' && auth()->check()) {
            $favorites = auth()->user()
                ->favorites()
                ->keywordSearch($keyword)
                ->get();
        }

        return view('index', compact('items', 'favorites', 'tab'));
    }
    //商品詳細画面
    public function show($item_id)
    {
        $user = Auth::user();
        $item = Item::findOrFail($item_id);

        return view('show', compact('item', 'user'));
    }
    //コメント登録
    public function commentCreate(CommentRequest $request, $item_id)
    {
        $comment = [
            'item_id' => $item_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ];

        Comment::create($comment);

        return redirect()->route('show', $item_id);
    }
    //お気に入り登録
    public function favorite(Request $request, $item_id)
    {
        $userId = Auth::id();

        $existing = Favorite::where('user_id', $userId)
            ->where('item_id', $item_id)
            ->first();

        if ($existing) {
            $existing->delete();
        } else {
            Favorite::create([
            'user_id' => $userId,
            'item_id' => $item_id,
            ]);
        }
        return redirect()->route('show', $item_id);
    }
    //購入画面表示
    public function purchase($item_id)
    {
        $user = Auth::user();
        $item  = Item::findOrFail($item_id);
        $payment_methods = PaymentMethod::all();
        $profile = Profile::where('user_id', Auth::id())->first();

        return view('purchase', compact('item', 'user', 'payment_methods', 'profile'));
    }
    //購入処理
    public function purchaseStore(PurchaseRequest $request, $item_id)
    {
        $item = Item::findOrFail($item_id);
        if ($item->order()->exists()) {
            return redirect()->route('show', $item_id);
        }

        $order =
        [
            'item_id' => $item_id,
            'user_id' => Auth::id(),
            'payment_method_id' => $request->payment_method,
            'postcode' => $request->postcode ,
            'address' => $request->address,
            'building' => $request->building,
        ];

        Order::create($order);

        $trade = Trade::create([
                'buyer_id' => Auth::id(),
                'seller_id' => $item->user_id,
                'item_id' => $item_id,
                'status' => Trade::STATUS_IN_PROGRESS,
                'buyer_completed_at' => null,
                'seller_reviewed_at' => null,
        ]);

        session()->forget('temp_address');

        return redirect()->route('chat.show', ['trade' => $trade->id]);
    }
    //住所変更のページ
    public function address($item_id)
    {
        $item = Item::findOrFail($item_id);

        return view('address', compact('item'));
    }
    //住所変更処理
    public function addressUpdate(AddressRequest $request, $item_id)
    {
        Session::put('temp_address', [
        'postcode' => $request->postcode,
        'address'  => $request->address,
        'building' => $request->building,
        ]);

        return redirect()->route('purchase', $item_id);
    }
    //出品画面の表示
    public function sell()
    {
        $categories = Category::all();
        return view('sell', compact('categories'));
    }
    //出品商品登録
    public function sellCreate(ExhibitionRequest $request)
    {
        $item = $request->only(['name','brand','price','description','condition']);
        $item['user_id'] = auth()->id();
        $path = $request->file('img_url')->store('items', 'public');
            $item['img_url'] = $path;

        $item = Item::create($item);

        if ($request->filled('categories')) {
            $item->categories()->sync($request->input('categories'));
        }
        return redirect()->route('mypage');
    }
    //マイページ画面表示
    public function mypage(Request $request)
    {
        $user = Auth::user();
        $profile = Profile::where('user_id', $user->id)->first();
        $items = Item::where('user_id', $user->id)->get();
        $orders = Order::with('item')->where('user_id', $user->id)->get();
        $page = $request->query('page', 'sell');
        $trades = Trade::with(['item','messages' => function ($query) {
            $query->latest();
        }])
        ->where(function ($query) use ($user) {
            $query->where('buyer_id', $user->id)
                ->orWhere('seller_id', $user->id);
        })
            ->where('status', Trade::STATUS_IN_PROGRESS)
            ->get()
            ->sortByDesc(function ($trade) {
                return optional($trade->messages->first())->created_at;
            });

        $averageRating = Review::where('reviewee_id', $user->id)->avg('rating');
        $rating = round($averageRating);
        $totalUnreadCount = Message::where('receiver_id', Auth::id())
            ->where('read', false)
            ->count();
        $tradeUnreadCounts = Message::where('receiver_id', Auth::id())
            ->where('read', false)
            ->selectRaw('trade_id, COUNT(*) as count')
            ->groupBy('trade_id')
            ->pluck('count', 'trade_id');

        return view('mypage', compact(
            'user',
            'profile',
            'items',
            'orders',
            'page',
            'trades',
            'averageRating',
            'rating',
            'totalUnreadCount',
            'tradeUnreadCounts'
        ));
    }
    //プロフィール登録画面表示(初回)
    public function showMypage()
    {
        $profile = Profile::where('user_id', Auth::id())->first();
        return view('profile', compact('profile'));
    }
    //プロフィール登録
    public function storeMypage(ProfileRequest $request)
    {
        $profile = $request->only(['name','postcode','address','building']);
        $profile['user_id'] = auth()->id();

        if ($request->hasFile('img_url')) {
            $path = $request->file('img_url')->store('profiles', 'public');
            $profile['img_url'] = $path;
        }
        Profile::create($profile);

        return redirect()->route('index');
    }
    //プロフィール更新
    public function storeUpdate(ProfileRequest $request)
    {
        $profile = $request->only(['name','postcode','address','building']);
        $profile['user_id'] = auth()->id();

        if ($request->hasFile('img_url')) {
            $path = $request->file('img_url')->store('profiles', 'public');
            $profile['img_url'] = $path;
        }

        profile::where('user_id', auth()->id()) -> update($profile);

        return redirect()->route('mypage');
    }
}
