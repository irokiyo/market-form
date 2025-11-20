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
    <h2 class="sell__ttl">商品の出品</h2>
    <form action="{{route('sell.create')}}" method="POST" class="sell__form" enctype="multipart/form-data">
        @csrf

        <div class="sell-block">
            <h3 class="sell-block__ttl">商品画像</h3>
            <div class="sell-image">
                <div class="sell-image-preview" id="preview"></div>
                <label class="sell-image__btn">
                    画像を選択する
                    <input type="file" id="img_url" name="img_url" accept="image/png, image/jpeg" class="img__btn">
                </label>
            </div>
            @error('img_url')
            <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="sell-block">
            <h2 class="sell-block__ttl-gray">商品の詳細</h2>

            <h3 class="sell-label">カテゴリー</h3>
            <div class="sell-categories">
                @foreach ($categories as $category)
                <label class="sell-category-tag">
                    <input type="checkbox" name="categories[]" value="{{ $category->id }}" class="sell-category-tag__input" >
                    <span class="sell-category-tag__label">{{ $category->category}}</span>
                </label>
                @endforeach
            </div>
            @error('categories')
            <p class="form-error">{{ $message }}</p>
            @enderror

            <p class="sell__label">商品の状態</p>
            <select name="condition" class="sell__select">
                <option value="">選択してください</option>
                <option value="良好">良好</option>
                <option value="目立った傷や汚れなし">目立った傷や汚れなし</option>
                <option value="やや傷や汚れあり">やや傷や汚れあり</option>
                <option value="状態が悪い">状態が悪い</option>
            </select>
            @error('condition')
            <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="sell-block">
            <h3 class="sell-block__ttl-gray">商品名と説明</h3>

            <div class="form-group">
                <label for="name" class="sell__label">商品名</label>
                <input type="text" id="name" name="name" class="sell__input" value="{{ old('name') }}">
                @error('name')
                <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="brand" class="sell__label">ブランド名</label>
                <input type="text" id="brand" name="brand" class="sell__input" value="{{ old('brand') }}">
                @error('brand')
                <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="description" class="sell__label">商品の説明</label>
                <textarea id="description" name="description" rows="5" class="sell__textarea">{{ old('description') }}</textarea>
                @error('description')
                <p class="form-error">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="price" class="sell__label">販売価格</label>
                <div class="sell-price">
                    <span class="sell-price__yen">¥</span>
                    <input type="text" id="price" name="price" class="sell__input" value="{{ old('price') }}">
                </div>
                @error('price')
                <p class="form-error">{{ $message }}</p>
                @enderror
            </div>
        </div>

        <button type="submit" class="sell-submit">出品する</button>
    </form>
</div>
<script>
    document.getElementById('img_url').addEventListener('change', function(event) {
        const file = event.target.files[0];
        const previewArea = document.getElementById('preview');
        previewArea.innerHTML = ''; // 過去の画像をクリア

        if (file && file.type.startsWith('image/')) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const img = document.createElement('img');
                img.src = e.target.result;
                previewArea.appendChild(img);
            };
            reader.readAsDataURL(file);
        } else {
            previewArea.textContent = '画像ファイルを選択してください。';
        }
    });

</script>

@endsection

