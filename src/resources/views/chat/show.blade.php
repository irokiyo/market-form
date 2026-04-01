@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
<link rel="stylesheet" href="{{ asset('css/chat.css') }}" />
@endsection

@section('header')
@endsection

@section('content')

<div class="card">
    <div class="left-card">
        <h2 class="category__ttl">その他の取引</h2>
    </div>
    <div class="right-card">
        <div class="sub__ttl">
            <h1 class="ttl">
                @if($trade->buyer)
                    @if((!empty($trade->seller->profile->img_url)))
                    <img src="{{ \Storage::url($trade->seller->profile->img_url) }}" id="preview-image" alt="プロフィール画像" class="avatar__img">
                    @else
                    <img src="{{asset('/images/Ellipse 1.png')}}" id="preview-image" alt="プロフィール画像" class="avatar__img">
                    @endif
                「{{$trade->seller->name}}」さんとの取引画面
                @elseif($trade->seller)
                    @if((!empty($trade->buyer->profile->img_url)))
                    <img src="{{ \Storage::url($trade->buyer->profile->img_url) }}" . id="preview-image" alt="プロフィール画像" class="avatar__img">
                    @else
                    <img src="{{asset('/images/Ellipse 1.png')}}" id="preview-image" alt="プロフィール画像" class="avatar__img">
                    @endif
                「{{$trade->buyer->name}}」さんとの取引画面
                @endif
            </h1>
            <div class="btn">
                @if($trade->buyer)
                <button class="completed_btn" type="submit">取引を完了する</button>
                @endif
            </div>
        </div>
        <div class="item-card">
            <div class="item__img">
                <img src="{{ \Storage::url($trade->item->img_url) }}" alt="商品画像">
            </div>
            <div class="item-detail">
                <div class="item__name">{{$trade->item->name}}</div>
                <div class="item__price">￥{{$trade->item->price}}</div>
            </div>
        </div>
        <div class="chat-card">
            <div class="chat-left">

            </div>
            <div class="chat right">
            @foreach($messages as $message)
            <div class="chat___user">
                <img src="{{ \Storage::url($trade->buyer->img_url) }}" alt="商品画像">
                <div class="user__name">{{$trade->buyer->name}}</div>
            </div>
            <div class="message__list">
                メッセージが入る
            </div>
            @if($message->isMine())
            <div class="message__edit">
                <button class="update" type="submit">編集</button>
                <button class="delete" type="submit">削除</button>
            </div>
            @endif
            @endforeach
            </div>
            <div class="message">
                <div class="message___form">
                <form action="">
                <textarea name="comment" id="comment" placeholder="取引メッセージを記入してください"></textarea>
                <input type="image" src="" alt="">画像を追加
                <input type="button" value=""><img src="/images/メッセージ送信.jpg" alt="送信ボタン">
                </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

