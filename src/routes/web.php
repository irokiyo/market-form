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


Route::middleware('auth')->group(function () {
    Route::get('/', [ItemController::class, 'index'])->name('index'); //商品一覧画面（トップ画面）
    Route::get('/item/{item_id}', [ItemController::class, 'show'])->name('show'); //商品詳細画面
    Route::post('/item/{item_id}', [ItemController::class, 'commentCreate'])->name('comment.create'); //商品詳細画面
    Route::get('/purchase/{item_id}', [ItemController::class, 'purchase'])->name('purchase'); //商品購入画面
    Route::get('/purchase/address/{item_id}', [ItemController::class, 'address'])->name('purchase.address'); //住所変更ページ
    Route::get('/sell', [ItemController::class, 'sell'])->name('sell'); //商品出品画面
    Route::post('/sell', [ItemController::class, 'sellCreate'])->name('sell.create'); //商品出品の登録

    Route::get('/mypage/profile', [ItemController::class, 'showMypage'])->name('profile.show'); //プロフィール画面編集（初回）画面
    Route::post('/mypage/profile', [ItemController::class, 'storeMypage'])->name('profile.store'); //プロフィール画面情報登録

    Route::get('/mypage', [ItemController::class, 'mypage'])->name('mypage'); //マイページ画面
});