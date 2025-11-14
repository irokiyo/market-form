<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ProfileRequest;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\Profile;
use App\Models\Category;



class ItemController extends Controller
{
    //商品一覧画面（トップ画面）
    public function index()
    {
        return view('index');
    }
    public function login()
    {
        return view('auth.login');
    }
    public function register()
    {
        return view('auth.register');
    }
    public function show()
    {
        return view('show');
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
        
        return redirect()->route('mypage');
    }
    //マイページ画面表示
    public function mypage()
    {
        return view('profile');
    }




    //プロフィール登録画面表示(初回)
    public function showMypage()
    {
        $profile = Profile::where('user_id', Auth::id())->first();
        return view('mypage',compact('profile'));
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

    public function purchase()
    {
        return view('purchase');
    }
}
