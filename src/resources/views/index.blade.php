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
    <div class="tab-menu">
        <a href="#" class="tab-item">おすすめ</a>
        <a href="#" class="tab-item">マイリスト</a>
    </div>

    {{-- 商品一覧 --}}
    <div class="items-list">
        @foreach($items as $item)
        <div class="item-card">
            <a href="#" class="show-link">
                <div class="item-img">
                    <img src="{{ \Storage::url($item->img_url) }}" alt="プロフィール画像" class="item-img">
                </div>
                <p class="item-name">{{$item->name}}</p>
            </a>
        </div>
        @endforeach
    </div>
</div>
@endsection
