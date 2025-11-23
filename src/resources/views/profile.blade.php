@extends('layouts.app')


@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
<link rel="stylesheet" href="{{ asset('css/profile.css') }}" />
@endsection

@section('header')
@include('partials.header')
@endsection


@section('content')
<div class="profile">
    <h2 class="profile-title">プロフィール設定</h2>

    <form action="{{$profile ? route('profile.update') : route('profile.store')}}" method="POST" class="profile-form" enctype="multipart/form-data">
        @csrf
        @if($profile)
        @method('PATCH')
        @endif

        <div class="avatar">
            <div class="avatar-circle">
                @if(!empty($profile?->img_url))
                <img src="{{ \Storage::url($profile->img_url) }}" . id="preview-image" alt="プロフィール画像" class="avatar__img">
                @else
                <img src="{{asset('/images/Ellipse 1.png')}}" id="preview-image" alt="プロフィール画像" class="avatar__img">
                @endif
            </div>
            <label class="avatar-button">
                画像を選択する
                <input type="file" id="img_url" name="img_url" accept="image/png, image/jpeg" class="img__btn">
            </label>
            @error('img_url')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="name">ユーザー名</label>
            <input type="text" id="name" name="name" value="{{ old('name',$profile->name ?? '') }}">
            @error('name')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="postcode">郵便番号</label>
            <input type="text" id="postcode" name="postcode" value="{{ old('postcode', $profile->postcode ?? '') }}">
            @error('postcode')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" id="address" name="address" value="{{ old('address', $profile->address ?? '') }}">
            @error('address')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" id="building" name="building" value="{{ old('building', $profile->building ?? '') }}">
            @error('building')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="profile-submit">更新する</button>
    </form>
</div>
<script>
    document.getElementById('img_url').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            const preview = document.getElementById('preview-image');
            preview.src = URL.createObjectURL(file);
        }
    });

</script>

@endsection

