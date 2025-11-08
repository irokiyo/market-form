<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
    public function sell()
    {
        return view('sell');
    }
    public function mypage()
    {
        return view('mypage');
    }
    public function purchase()
    {
        return view('purchase');
    }
}
