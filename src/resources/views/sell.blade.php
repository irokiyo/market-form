@extends('layouts.app')


@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
<link rel="stylesheet" href="{{ asset('css/sell.css') }}" />
@endsection

@section('header')
@include('partials.header')
@endsection


@section('content')
<div class="sell">
    <h2 class="sell__title">商品の出品</h2>

    {{-- 実際は route('items.store') などに変えてください --}}
    <form action="" method="POST" enctype="multipart/form-data" class="sell__form">
        @csrf

        {{-- 商品画像 --}}
        <div class="sell-block">
            <h3 class="sell-block__title">商品画像</h3>
            <p class="sell-block__note"></p>
            <label class="sell-image-drop">
                <span class="sell-image-drop__text">画像を選択する</span>
                <input type="file" name="image" accept="image/*" hidden>
            </label>
            @error('image')
            <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 商品の詳細 --}}
        <div class="sell-block">
            <h3 class="sell-block__title">商品の詳細</h3>
            <hr class="sell-divider">

            <p class="sell-label">カテゴリー</p>
            <div class="sell-categories">
                {{-- 本番では $categories を回せばOK --}}
                @foreach (['ファッション','家電','インテリア','レディース','メンズ','コスメ','本','ゲーム','スポーツ','キッチン','ハンドメイド','アクセサリー','おもちゃ','ベビー・キッズ'] as $category)
                <label class="sell-category-tag">
                    <input type="radio" name="category_id" value="{{ $category }}" class="sell-category-tag__input">
                    <span class="sell-category-tag__label">{{ $category }}</span>
                </label>
                @endforeach
            </div>
            @error('category_id')
            <p class="form-error">{{ $message }}</p>
            @enderror

            <p class="sell-label">商品の状態</p>
            <select name="condition" class="sell-select">
                <option value="">選択してください</option>
                <option value="新品">新品</option>
                <option value="未使用に近い">未使用に近い</option>
                <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                <option value="傷や汚れあり">傷や汚れあり</option>
            </select>
            @error('condition')
            <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        {{-- 商品名と説明 --}}
        <div class="sell-block">
            <h3 class="sell-block__title">商品名と説明</h3>
            <hr class="sell-divider">

            <div class="form-group">
                <label for="name" class="sell-label">商品名</label>
                <input type="text" id="name" name="name" class="sell-input" value="{{ old('name') }}">
                @error('name')
                <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="brand" class="sell-label">ブランド名</label>
                <input type="text" id="brand" name="brand" class="sell-input" value="{{ old('brand') }}">
                @error('brand')
                <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="description" class="sell-label">商品の説明</label>
                <textarea id="description" name="description" rows="5" class="sell-textarea">{{ old('description') }}</textarea>
                @error('description')
                <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="price" class="sell-label">販売価格</label>
                <div class="sell-price">
                    <span class="sell-price__yen">¥</span>
                    <input type="number" id="price" name="price" class="sell-input" value="{{ old('price') }}">
                </div>
                @error('price')
                <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <button type="submit" class="sell-submit">出品する</button>
    </form>
</div>
@endsection

