@extends('layouts.app')


@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('header')
@include('partials.header')
@endsection


@section('content')
<div class="items-page">
    {{-- タブ部分 --}}
    <div class="tab-menu">
        <a href="#" class="tab-item">おすすめ</a>
        <a href="#" class="tab-item">マイリスト</a>
    </div>

    {{-- 商品一覧 --}}
    <div class="items-list">
        {{-- ここは本当は @foreach($items as $item) ... にするところ --}}
        <div class="item-card">
            <div class="item-img">商品画像</div>
            <p class="item-name">商品名</p>
        </div>
        <div class="item-card">
            <div class="item-img">商品画像</div>
            <p class="item-name">商品名</p>
        </div>
        <div class="item-card">
            <div class="item-img">商品画像</div>
            <p class="item-name">商品名</p>
        </div>
    </div>
</div>
@endsection