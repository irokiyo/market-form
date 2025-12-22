@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
<link rel="stylesheet" href="{{ asset('css/purchase.css') }}" />
@endsection

@section('header')
@include('partials.header')
@endsection

@section('content')
<form id="purchase-form" action="{{ route('checkout.create', $item->id) }}" method="POST" class="sell__form" enctype="multipart/form-data">
    @csrf
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
                    <select name="payment_method" class="purchase-select" id="payment_method">
                        <option value="">選択してください</option>
                        @foreach ($payment_methods as $payment_method)
                        <option value="{{ $payment_method->id }}" data-action="{{ $payment_method->payment_method === 'カード支払い'
                        ? route('checkout.create', $item->id)
                        : route('purchase.store', $item->id)
                            }}">{{ $payment_method->payment_method }}</option>

                        @endforeach
                    </select>
                    @error('payment_method')
                    <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>

                <hr class="purchase__line">

                <div class="purchase-block">
                    <div class="purchase-block__head">
                        <h2 class="purchase-block__title">配送先</h2>
                        <a href="{{route('purchase.address',$item->id)}}" class="purchase-block__link">変更する</a>
                    </div>

                    @php
                    $temp = session('temp_address'); // 一時住所
                    $postcode = $temp['postcode'] ?? ($profile?->postcode ?? '');
                    $address = $temp['address'] ?? ($profile?->address ?? '');
                    $building = $temp['building'] ?? ($profile?->building ?? '');
                    @endphp

                    <div class="purchase-address">
                        <p>〒 {{$postcode}}</p>
                        <p>{{$address}}</p>
                        <p>{{$building}}</p>

                        <input type="hidden" name="postcode" value="{{ $postcode }}">
                        <input type="hidden" name="address" value="{{ $address }}">
                        <input type="hidden" name="building" value="{{ $building }}">

                        @error('postcode')
                        <p class="error-message">{{ $message }}</p>
                        @enderror
                        @error('address')

                        <p class="error-message">{{ $message }}</p>
                        @enderror

                    </div>
                </div>

                <hr class="purchase__line">
            </div>

            <div class="purchase__right">
                <div class="purchase-summary">
                    <div class="purchase-summary__row">
                        <span class="purchase-summary__label">商品代金</span>
                        <span class="purchase-summary__value">¥ {{$item->price}}</span>
                    </div>
                    <div class="purchase-summary__row">
                        <p class="purchase-summary__label">支払い方法</p>
                        <span class="purchase-summary__label" id="payment_method_label"></span>
                    </div>
                </div>
                <button type="submit" class="purchase-btn">購入する</button>
            </div>

        </div>
    </div>
</form>
<script>
    const select = document.getElementById('payment_method');
    const label = document.getElementById('payment_method_label');

    select.addEventListener('change', function() {
        label.textContent = this.options[this.selectedIndex].text;
    });

</script>

<script>
    document.getElementById('purchase-form').addEventListener('submit', function(e) {
        const select = document.getElementById('payment_method');
        const option = select.options[select.selectedIndex];

        if (!option.value) {
            return;
        }

        this.action = option.dataset.action;
    });

</script>

@endsection

