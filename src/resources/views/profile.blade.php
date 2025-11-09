@extends('layouts.app')


@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
<link rel="stylesheet" href="{{ asset('css/profile.css') }}" />
@endsection

@section('header')
@include('partials.header')
@endsection


@section('content')
<div class="mypage">
    {{-- プロフィールヘッダー --}}
    <div class="mypage__header">
        <div class="mypage__avatar">
            @if(!empty($user?->avatar_path))
            <img src="{{ asset('storage/' . $user->avatar_path) }}" alt="プロフィール画像" class="mypage__avatar-img">
            @else
            <div class="mypage__avatar-placeholder"></div>
            @endif
        </div>
        <div class="mypage__info">
            <p class="mypage__name">{{ $user->name ?? 'ユーザー名' }}</p>
        </div>
        <div class="mypage__actions">
            <a href="{{ route('mypage.edit') }}" class="mypage__edit-btn">プロフィールを編集</a>
        </div>
    </div>

    {{-- タブ --}}
    <div class="mypage__tabs">
        <button class="mypage-tab is-active" data-tab="sold">出品した商品</button>
        <button class="mypage-tab" data-tab="bought">購入した商品</button>
    </div>

    <hr class="mypage__line">

    {{-- 出品した商品 --}}
    <div class="mypage__list" id="tab-sold">
        <div class="mypage-grid">
            {{-- 本番は $soldItems を回す --}}
            @forelse($soldItems ?? [] as $item)
            <div class="mypage-card">
                <div class="mypage-card__img-wrap">
                    <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="mypage-card__img">
                </div>
                <p class="mypage-card__title">{{ $item->name }}</p>
            </div>
            @empty
            {{-- ダミー表示（デザイン確認用） --}}
            @for($i = 0; $i < 5; $i++) <div class="mypage-card">
                <div class="mypage-card__img-wrap placeholder">商品画像</div>
                <p class="mypage-card__title">商品名</p>
        </div>
        @endfor
        @endforelse
    </div>
</div>

{{-- 購入した商品 --}}
<div class="mypage__list is-hidden" id="tab-bought">
    <div class="mypage-grid">
        @forelse($boughtItems ?? [] as $item)
        <div class="mypage-card">
            <div class="mypage-card__img-wrap">
                <img src="{{ asset('storage/' . $item->image_path) }}" alt="{{ $item->name }}" class="mypage-card__img">
            </div>
            <p class="mypage-card__title">{{ $item->name }}</p>
        </div>
        @empty
        <p>購入した商品はまだありません。</p>
        @endforelse
    </div>
</div>
</div>

{{-- タブ切り替え用の超シンプルJS（必要なければ消してOK） --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const tabs = document.querySelectorAll('.mypage-tab');
        const lists = {
            sold: document.getElementById('tab-sold')
            , bought: document.getElementById('tab-bought')
        , };

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                tabs.forEach(t => t.classList.remove('is-active'));
                tab.classList.add('is-active');

                const target = tab.dataset.tab;
                Object.values(lists).forEach(el => el.classList.add('is-hidden'));
                lists[target].classList.remove('is-hidden');
            });
        });
    });

</script>
@endsection

