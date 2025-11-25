@extends('layouts.app')


@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
<link rel="stylesheet" href="{{ asset('css/index.css') }}" />
@endsection

@section('header')
@include('partials.header')
@endsection


@section('content')

@php
$tab = request('tab', '');
@endphp

<div class="items-page">
    <div class="tab-menu">
        <a href="{{route('index', ['tab' => ''])}}" class="tab {{ $tab === '' ? 'is-active' : '' }}" >おすすめ</a>
        <a href="{{route('index', ['tab' => 'mylist'])}}" class="tab {{ $tab === 'mylist' ? 'is-active' : '' }}">マイリスト</a>
    </div>

    {{-- おすすめ --}}
    <div class="items-list {{ $tab==='' ? '' : 'is-hidden' }}" id="tab-">
        @foreach($items as $item)
        <div class="item-card">
            <a href="{{ route('show', $item->id) }}" class="show-link">
                <div class="item-img">
                    <img src="{{ \Storage::url($item->img_url) }}" alt="プロフィール画像" class="item-img">
                </div>
                <p class="item-name">{{$item->name}}</p>
            </a>
        </div>
        @endforeach
    </div>
    {{-- マイリスト --}}
    <div class="items-list {{ $tab==='mylist' ? '' : 'is-hidden' }}">
        @foreach($favorites as $favorite)
        <div class="item-card">
            <a href="{{ route('show', $favorite->item->id) }}" class="show-link">
                <div class="item-img">
                    <img src="{{ \Storage::url($favorite->item->img_url) }}" alt="プロフィール画像" class="item-img">
                </div>
                <p class="item-name">{{$favorite->item->name}}</p>
            </a>
        </div>
        @endforeach
    </div>

</div>
@endsection
