@extends('layouts.app')


@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
<link rel="stylesheet" href="{{ asset('css/address.css') }}" />
@endsection

@section('header')
@include('partials.header')
@endsection


@section('content')
<div class="address-edit">
    <h2 class="address-edit__title">住所の変更</h2>

    {{-- 実際は action に更新用のルートを入れる --}}
    <form action="" method="POST" class="address-edit__form">
        @csrf
        @method('PATCH')

        <div class="form__group">
            <label for="postcode" class="form__label">郵便番号</label>
            <input type="text" id="postcode" name="postcode" class="form__input" value="{{ old('postcode') }}">
            @error('postcode')
            <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form__group">
            <label for="address" class="form-label">住所</label>
            <input type="text" id="address" name="address" class="form__input" value="{{ old('address') }}">
            @error('address')
            <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="form__group">
            <label for="building" class="form-label">建物名</label>
            <input type="text" id="building" name="building" class="form__input" value="{{ old('building') }}">
            @error('building')
            <p class="form-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="address-edit__btn">更新する</button>
    </form>
</div>
@endsection
