@extends('layouts.app')


@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}" />
@endsection

@section('header')
@include('partials.header')
@endsection


@section('content')

<div class="mypage">
    <div class="mypage__header">
        <div class="avatar">
            @if(!empty($profile?->img_url))
            <img src="{{ \Storage::url($profile->img_url) }}" alt="プロフィール画像" class="avatar__img">
            @else
            <img src="{{asset('/images/Ellipse 1.png')}}" alt="プロフィール画像" class="avatar__img">
            @endif
        </div>
        <div class="mypage__info">
            <p class="mypage__name">{{ $profile->name }}</p>
        </div>
        <div class="mypage__btn">
            <a href="{{ route('profile.show') }}" class="mypage__edit-btn">プロフィールを編集</a>
        </div>
    </div>

    <div class="mypage__tabs">
        <ul class="tabs__list">
            <li><a href="{{route('mypage', ['page' => 'sell'])}}" class="page {{ $page === 'sell' ? 'is-active' : '' }}">出品した商品</a></li>
            <li><a href="{{route('mypage', ['page' => 'buy'])}}" class="page {{ $page === 'buy' ? 'is-active' : '' }}">購入した商品</a></li>
        </ul>
    </div>
    <div class="line"></div>

    {{-- 出品した商品 --}}
    <div class="mypage__list {{ $page==='sell' ? '' : 'is-hidden' }}" id="tab-sell">
        <div class="mypage-grid">
            @foreach($items as $item)
            <div class="item-card">
                <img src="{{ \Storage::url($item->img_url) }}" class="item__img" alt="商品画像">
                <p class="item__name">{{$item->name}}</p>
            </div>
            @endforeach
        </div>
    </div>

    {{-- 購入した商品 --}}
    <div class="mypage__list {{ $page==='buy' ? '' : 'is-hidden' }}" id="tab-order">
        <div class="mypage-grid">
            @foreach($orders as $order)
            <div class="item-card">
                <img src="{{ \Storage::url($order->item->img_url) }}" alt="{{ $order->item->name }}" class="item__img">
                <p class="item__name">{{$order->item->name}}</p>
            </div>
            @endforeach
        </div>
    </div>
</div>
    @endsection

