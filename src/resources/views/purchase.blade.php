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

        <div class="purchase__left">

            <div class="purchase-item">
                <div class="purchase-item__image">
                    <img src="{{ \Storage::url($item->img_url) }}" alt="商品画像" class="show-left__img">
                </div>
                <div class="purchase-item__info">
                    <p class="purchase-item__name">{{$item->name}}</p>
                    <p class="purchase-item__price">¥ {{$item->price}}</p>
                </div>
            </div>

            <hr class="purchase__line">

            <div class="purchase-block">
                <h2 class="purchase-block__ttl">支払い方法</h2>
                <select name="payment_method" class="purchase-select" id="payment_method_select">

                    <option value="">選択してください</option>
                    @foreach ($payment_methods as $payment_method)
                    <option value="{{ $payment_method->id }}">{{ $payment_method->payment_method }}</option>
                    @endforeach
                </select>
            </div>

            <hr class="purchase__line">

            <div class="purchase-block">
                <div class="purchase-block__head">
                    <h2 class="purchase-block__title">配送先</h2>
                    <a href="#" class="purchase-block__link">変更する</a>
                </div>
                <p class="purchase-address">
                    〒 {{$profile->postcode}}<br>
                    {{$profile->address}}<br>
                    {{$profile->building}}
                </p>
            </div>

        </div>

        <div class="purchase__right">
            <div class="purchase-summary">
                <div class="purchase-summary__row">
                    <span class="purchase-summary__label">商品代金</span>
                    <span class="purchase-summary__value">¥ {{$item->price}}</span>
                </div>
                <div class="purchase-summary__row">
                    <p class="purchase-summary__label">支払い方法</p><span class="purchase-summary__label" id="payment_method_label"></span>
                </div>
            </div>

            <button class="purchase-btn">購入する</button>
        </div>

    </div>
</div>
<script>
    document.getElementById('payment_method_select').addEventListener('change', function() {
        const selectedText = this.options[this.selectedIndex].text;
        document.getElementById('payment_method_label').textContent = selectedText;
    });

</script>
@endsection

