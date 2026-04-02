@extends('layouts.app')

@section('css')
<link rel="stylesheet" href="{{ asset('css/sanitize.css') }}" />
<link rel="stylesheet" href="{{ asset('css/chat.css') }}" />
<link rel="stylesheet" href="{{ asset('css/modal.css') }}" />
@endsection

@section('header')
@endsection

@section('content')

<div class="card">
    <div class="left-card">
        <h2 class="category__ttl">その他の取引</h2>
        @foreach($trades as $t)
        @if($t->id !== $trade->id)
        <div class="progress___list">
            <a href="{{route('chat.show',['trade' => $t->id])}}">
                <p class="item__name">{{$t->item->name}}</p>
            </a>
        </div>
        @endif
        @endforeach
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
                <button class="completed_btn" type="button" id="openModal">取引を完了する</button>
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
            @foreach($messages as $message)
            <div class="{{ $message->isMine() ? 'chat-right' : 'chat-left' }}">

                <div class="chat___user">
                    <div class="user__name">{{$trade->buyer->name}}</div>
                    <img src="{{ \Storage::url($trade->buyer->img_url) }}" alt="プロフィール画像">
                </div>
                <div class="chat__message">
                    <div class="comment">
                        {{$message->comment}}
                    </div>
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
                    <form action="{{route('message.store', ['trade' => $trade->id])}}" method='post' enctype="multipart/form-data">
                        @csrf
                        <textarea class="form__textarea" name="comment" id="comment" placeholder="取引メッセージを記入してください">
                        </textarea>
                        <label for="" class="img__upload">
                            画像を追加<input type="image" src="" alt="" hidden>
                        </label>
                        <button class="send__btn" type="submit"><img src="/images/メッセージ送信.jpg" alt="送信ボタン">
                        </button>
                    </form>
                    @error('comment')
                    <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
@include('chat.modal')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        //モーダルの取得するボタンの連動
        const openBtn = document.getElementById('openModal');
        //モーダル本体を取得
        const modal = document.getElementById('reviewModal');

        //モーダル開く処理
        if (openBtn && modal) {
            openBtn.addEventListener('click', function() {
                modal.classList.add('is-open');
            });
        }
    });

</script>
@endsection