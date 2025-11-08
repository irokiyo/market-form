<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/



Route::get('/', [ItemController::class, 'index'])->name('index'); //商品一覧画面（トップ画面）
Route::get('/register', [ItemController::class, 'register'])->name('register'); //会員登録画面
Route::get('/login', [ItemController::class, 'login'])->name('login'); //ログイン画面
Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('show'); //商品詳細画面
Route::get('/purchase/{item_id}', [ItemController::class, 'purchase'])->name('purchase'); //商品購入画面
Route::get('/purchase/address/{item_id}', [ItemController::class, 'address'])->name('purchase.address'); //住所変更ページ
Route::get('/sell', [ItemController::class, 'sell'])->name('sell'); //商品出品画面
Route::get('/mypage', [ItemController::class, 'mypage'])->name('mypage'); //プロフィール画面
Route::get('/mypage/profile', [ItemController::class, 'edit'])->name('mypage.edit'); //プロフィール編集画面



//完成したら消去するルート
Route::get('/show', [ItemController::class, 'show'])->name('show'); //商品詳細画面
Route::get('/purchase', [ItemController::class, 'purchase'])->name('purchase');
Route::get('/address', [ItemController::class, 'address'])->name('purchase.address'); 