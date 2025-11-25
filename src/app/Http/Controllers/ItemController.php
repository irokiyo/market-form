<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\Category;
use App\Models\Comment;
use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\PaymentMethod;
use App\Models\Favorite;



class ItemController extends Controller
{
    //商品一覧画面（トップ画面）
    public function index(Request $request)
    {
        $user = Auth::user();
        $items = Item::all();
        $favorites = Favorite::all();
        $tab = $request->query('tab', '');

        return view('index',compact('user','items','favorites','tab'));
    }

    //商品詳細画面
    public function show($item_id)
    {
        $user = Auth::user();
        $item = Item::findOrFail($item_id);

        return view('show',compact('item','user'));
    }
    //コメント登録
    public function commentCreate(Request $request,$item_id)
    {
        $comment = [
            'item_id' => $item_id,
            'user_id' => Auth::id(),
            'comment' => $request->comment,
        ];

        Comment::create($comment);

        return redirect()->route('show', $item_id);
    }

    //購入画面表示
    public function purchase($item_id)
    {
        $user = Auth::user();
        $item  = Item::findOrFail($item_id);
        $payment_methods = PaymentMethod::all();
        $profile = Profile::where('user_id', Auth::id())->first();

        return view('purchase',compact('item','user','payment_methods','profile'));
    }


    public function address()
    {
        return view('address');
    }


    //出品画面の表示
    public function sell()
    {
        $categories=Category::all();
        return view('sell',compact('categories'));
    }

    //出品商品登録
    public function sellCreate(ExhibitionRequest $request)
    {
        $item = $request->only(['name','brand','price','description','condition']);
        $item['user_id'] = auth()->id();
        $path = $request->file('img_url')->store('items', 'public');
            $item['img_url'] = $path;

        $item=Item::create($item);

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

        return view('mypage',compact('user','profile','items','orders','page'));
    }

    //プロフィール登録画面表示(初回)
    public function showMypage()
    {
        $profile = Profile::where('user_id', Auth::id())->first();
        return view('profile',compact('profile'));
    }

    //プロフィール登録
    public function storeMypage(ProfileRequest $request)
    {
        $profile = $request->only(['name','postcode','address','building']);
        $profile['user_id'] = auth()->id();

        if($request->hasFile('img_url')) {
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

        if($request->hasFile('img_url')) {
            $path = $request->file('img_url')->store('profiles', 'public');
            $profile['img_url'] = $path;
        }

        profile::where('user_id', auth()->id()) -> update($profile);

        return redirect()->route('mypage');
    }
}
