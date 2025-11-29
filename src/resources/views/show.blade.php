@extends('layouts.app')


@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
<link rel="stylesheet" href="{{ asset('css/show.css') }}" />
@endsection

@section('header')
@include('partials.header')
@endsection


@section('content')
<div class="show">
    <div class="show__inner">

        <div class="show-left">
            <img src="{{ \Storage::url($item->img_url) }}" alt="商品画像" class="show-left__img">
        </div>

        <div class="show-right">
            <h2 class="item-name">{{$item->name}}</h2>
            <p class="item-brand">{{$item->brand ?? ''}}</p>
            <p class="item-price">¥<span class="item-price">{{$item->price}}</span>（税込）</p>
            <div class="item-actions">
                <div class="item__actions-icons">
                    <div class="item-like">
                        <form action="{{route('favorite',$item->id)}}" method="POST" class="favorite-form">
                        @csrf
                            <button class="item__like-icon" type="submit"><i class="fa-2xl {{$item->liked() ? 'fa-solid fa-heart' : 'fa-regular fa-heart'}}"></i></button>

                        </form>
                        <span class="item__like-count">{{$item->favoriteUsers->count()}}</span>
                    </div>
                    <div class="item__comment">
                        <span class="item__comment-icon"><i class="fa-2xl fa-regular fa-comment"></i></span>

                        <span class="item__comment-count">{{$item->comments->count()}}</span>
                    </div>
                </div>
                <div class="purchase">
                <a href="{{route('purchase',$item->id)}}" class="btn">購入手続きへ</a>
                </div>
            </div>

            <section class="item__section">
                <h3 class="section-title">商品説明</h3>
                <p class="item-desc">
                    {{$item->description}}
                </p>
            </section>

            {{-- 商品の情報 --}}
            <table class="item__section">
                <h3 class="section-title">商品の情報</h3>
                <tr class="table-row">
                    <td class="item-info-label">カテゴリー</td>
                    <td class="item-tags">
                        @foreach($item->categories as $category)
                            <span class="item-tag">{{$category->category}}</span>
                        @endforeach
                    </td>
                </tr>

                <tr class="table-row">
                    <td class="item-info-label">商品の状態</td>
                    <td class="item-status">{{$item->condition}}</td>

                </tr>
            </table>

            <section class="item-section">
                <h3 class="section-title">コメント({{$item->comments->count()}})</h3>

                <div class="comment">
                    @foreach($item->comments as $comment)
                    <div class="comment__icon">
                        @php
                        $profile = optional($comment->user->profile);
                        @endphp

                        @if($profile->img_url)
                        <img src="{{ Storage::url($profile->img_url) }}" class="comment__icon-img">
                        @else
                        <img src="{{ asset('/images/Ellipse 1.png') }}" class="comment__icon-img">
                        @endif

                        <p class="comment__name">{{$comment->user->profile->name}}</p>
                    </div>
                    <div class="comment__body">
                        <p class="comment__text">{{$comment->comment}}</p>
                    </div>
                    @endforeach
                </div>
            </section>

            <section class="item-section">
                <h3 class="section-title">商品のコメント</h3>
                <form action="{{route('comment.create',$item->id)}}" method="POST" class="comment-form">
                    @csrf
                    <textarea name="comment" rows="4" class="comment-form__textarea"></textarea>
                    <button type="submit" class="btn-comment">コメントを送信する</button>
                </form>
                @error('comment')
                <p class="form-error">{{ $message }}</p>
                @enderror
            </section>
        </div>
    </div>
</div>
@endsection

