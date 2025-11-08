@extends('layouts.app')


@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
<link rel="stylesheet" href="{{ asset('css/show.css') }}" />
@endsection

@section('header')
    @include('partials.header')
@endsection


@section('content')
<div class="show">
    <div class="show__inner">

        <div class="show-left">
            <img src="{{asset('/images/Rectangle 3.png')}}" alt="商品画像" class="show-left__img">
        </div>

        <div class="show-right">
            <h2 class="item-title">商品名がここに入る</h2>
            <p class="item-brand">ブランド名</p>
            <p class="item-price">¥47,000 <span class="item-tax">（税込）</span></p>
            <div class="item-actions">
                <div class="item__actions-icons">
                    <div class="item-like">
                        <span class="item__like-icon"><img src="{{asset('/images/like.png')}}" alt="お気に入り" ></span>
                        <span class="item__like-count">3</span>
                    </div>
                    <div class="item__comment">
                        <span class="item__comment-icon"><img src="{{asset('/images/comment.png')}}" alt="コメント"></span>
                        <span class="item__comment-count">1</span>
                    </div>
                </div>
                <a href="" class="item-buy-btn">購入手続きへ</a>
            </div>

            {{-- 商品説明 --}}
            <section class="item__section">
                <h3 class="section-title">商品説明</h3>
                <p class="item-desc">
                    カラー：グレー<br>
                    新品。<br>
                    商品の状態は良好です。傷もありません。<br>
                    購入後、即発送いたします。
                </p>
            </section>

            {{-- 商品の情報 --}}
            <table class="item__section">
                <th class="table-title">商品の情報</th>

                <tr class="table-row">
                    <td class="item-info-label">カテゴリー</td>
                    <td class="item-tags">
                        <span class="item-tag">洋服</span>
                        <span class="item-tag">メンズ</span>
                    </td>
                </tr>

                <tr class="table-row">
                    <td class="item-info-label">商品の状態</td>
                    <td class="item-status">良好</td>
                </tr>
            </table>

            <section class="item-section">
                <h3 class="section-title">コメント（1）</h3>

                <div class="comment">
                    <div class="comment__icon"></div>
                    <div class="comment__body">
                        <p class="comment__name">admin</p>
                        <p class="comment__text">こちらにコメントが入ります。</p>
                    </div>
                </div>
            </section>

            <section class="item-section">
                <h3 class="section-title">商品のコメント</h3>
                <form action="" method="POST" class="comment-form">
                    @csrf
                    <textarea name="comment" rows="4" class="comment-form__textarea" ></textarea>
                    <button type="submit" class="comment__form-btn">コメントを送信する</button>
                </form>
            </section>
        </div>
    </div>
</div>
@endsection
