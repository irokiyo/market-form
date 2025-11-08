@extends('layouts.app')


@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}" />
@endsection

@section('header')
@include('partials.header')
@endsection


@section('content')
<div class="purchase">
    <div class="purchase__inner">

        {{-- 左カラム --}}
        <div class="purchase__left">

            {{-- 商品情報 --}}
            <div class="purchase-item">
                <div class="purchase-item__image">
                    {{-- 実際は $item->image_path などに差し替え --}}
                    <div class="purchase-item__image--placeholder">商品画像</div>
                </div>
                <div class="purchase-item__info">
                    <p class="purchase-item__name">商品名</p>
                    <p class="purchase-item__price">¥ 47,000</p>
                </div>
            </div>

            <hr class="purchase__line">

            {{-- 支払い方法 --}}
            <div class="purchase-block">
                <h2 class="purchase-block__title">支払い方法</h2>
                <select name="payment_method" class="purchase-select">
                    <option value="">選択してください</option>
                    <option value="conveni">コンビニ払い</option>
                    <option value="card">クレジットカード</option>
                    <option value="bank">銀行振込</option>
                </select>
            </div>

            <hr class="purchase__line">

            {{-- 配送先 --}}
            <div class="purchase-block">
                <div class="purchase-block__head">
                    <h2 class="purchase-block__title">配送先</h2>
                    <a href="#" class="purchase-block__link">変更する</a>
                </div>
                <p class="purchase-address">
                    〒 XXX-YYYY<br>
                    ここには住所と建物が入ります
                </p>
            </div>

        </div>

        {{-- 右カラム --}}
        <div class="purchase__right">
            <div class="purchase-summary">
                <div class="purchase-summary__row">
                    <span class="purchase-summary__label">商品代金</span>
                    <span class="purchase-summary__value">¥ 47,000</span>
                </div>
                <div class="purchase-summary__row">
                    <span class="purchase-summary__label">支払い方法</span>
                    <span class="purchase-summary__value">コンビニ払い</span>
                </div>
            </div>

            <button class="purchase-btn">購入する</button>
        </div>

    </div>
</div>
@endsection

