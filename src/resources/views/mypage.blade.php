@extends('layouts.app')


@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
<link rel="stylesheet" href="{{ asset('css/mypage.css') }}" />
@endsection

@section('header')
@include('partials.header')
@endsection


@section('content')
<div class="profile">
    <h2 class="profile-title">プロフィール設定</h2>

    <form action="" method="POST" class="profile-form">
        @csrf

        <div class="avatar">
            <div class="avatar-circle">
                <img src="{{asset('/images/Ellipse 1.png')}}" alt="グレーのマル">
            </div>
            <label class="avatar-button">
                画像を選択する
                <input type="file" name="avatar" accept="image/*" class="avatar-button-hidden" hidden>

            </label>
            @error('avatar')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="name">ユーザー名</label>
            <input type="text" id="name" name="name" value="{{ old('name') }}">
            @error('name')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="postcode">郵便番号</label>
            <input type="text" id="postcode" name="postcode" value="{{ old('postcode') }}">
            @error('postcode')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="address">住所</label>
            <input type="text" id="address" name="address" value="{{ old('address') }}">
            @error('address')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <div class="form-group">
            <label for="building">建物名</label>
            <input type="text" id="building" name="building" value="{{ old('building') }}">
            @error('building')
            <p class="error-message">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="profile-submit">登録する</button>
    </form>
</div>
@endsection

