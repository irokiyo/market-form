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
            <a href="{{route('chat.show',['trade' => $t->id])}}" class="progress___list__link">
                <p class="progress___list__item__name">{{$t->item->name}}</p>
            </a>
        </div>
        @endif
        @endforeach
    </div>
    <div class="right-card">
        <div class="sub__ttl">
            <h1 class="ttl">
                @if(auth()->id() === $trade->buyer_id)
                    @if((!empty($trade->seller->profile->img_url)))
                    <img src="{{ \Storage::url($trade->seller->profile->img_url) }}" id="preview-image" alt="プロフィール画像" class="avatar__img">
                    @else
                    <img src="{{asset('images/Ellipse 1.png')}}" id="preview-image" alt="プロフィール画像" class="avatar__img">
                    @endif
                「{{$trade->seller->name}}」さんとの取引画面
                @elseif(auth()->id() === $trade->seller_id)
                    @if((!empty($trade->buyer->profile->img_url)))
                    <img src="{{ \Storage::url($trade->buyer->profile->img_url) }}" id="preview-image" alt="プロフィール画像" class="avatar__img">
                    @else
                    <img src="{{asset('images/Ellipse 1.png')}}" id="preview-image" alt="プロフィール画像" class="avatar__img">
                    @endif
                「{{$trade->buyer->name}}」さんとの取引画面
                @endif
            </h1>
            <div class="btn">
                @if(auth()->id()===$trade->buyer_id)
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
            <div class="chat-area">
                @foreach($messages as $chatMessage)
                <div class="{{ $chatMessage->isMine() ? 'chat-right' : 'chat-left' }}">
                    <div class="chat___user">
                        @if($chatMessage->user_id === $trade->buyer_id)
                        <div class="user__name">{{$trade->buyer->name}}</div>
                            @if((!empty($trade->buyer->profile->img_url)))
                            <img src="{{ \Storage::url($trade->buyer->profile->img_url) }}" alt="プロフィール画像">
                            @else
                            <img src="{{asset('images/Ellipse 1.png')}}" id="preview-image" alt="プロフィール画像" class="avatar__img">
                            @endif
                        @elseif($chatMessage->user_id === $trade->seller_id)
                        <div class="user__name">{{$trade->seller->name}}</div>
                            @if((!empty($trade->seller->profile->img_url)))
                            <img src="{{ \Storage::url($trade->seller->profile->img_url) }}" alt="プロフィール画像">
                            @else
                            <img src="{{asset('images/Ellipse 1.png')}}" id="preview-image" alt="プロフィール画像" class="avatar__img">
                            @endif
                        @endif
                    </div>

                    <div class="chat__message">
                        <div class="comment">
                            @if($editMessage == $chatMessage->id)
                            <form action="{{route('message.update',['trade' => $trade->id , 'message' => $chatMessage->id])}}" method="post" enctype="multipart/form-data">
                                @csrf
                                @method('patch')
                                <a href="{{route('chat.show',['trade'=>$trade->id])}}" class="cancel__btn">×</a>
                                <textarea class="edit__textarea" name="comment">{{ $chatMessage->comment }}</textarea>
                                <img src="{{ Storage::url($chatMessage->image_url) }}" alt="送信画像" class="message__img">
                                <label for="editId" class="img__upload">画像を変更</label>
                                <input type="file" name="img_url" id="editId" hidden>
                                <button class="update" type="submit">編集する</button>
                            </form>
                            @else
                            {{ $chatMessage->comment }}
                            @if(!empty($chatMessage->image_url))
                            <img src="{{ Storage::url($chatMessage->image_url) }}" alt="送信画像" class="message__img">
                            @endif
                            @endif
                        </div>
                    </div>
                    @if($chatMessage->isMine())
                    <div class="message__edit">
                        <a href="{{route('chat.show',['trade'=>$trade->id, 'edit'=>$chatMessage->id])}}" class="update">編集</a>
                        <form action="{{route('message.delete',['trade' => $trade->id , 'message' => $chatMessage->id])}}" method="post">
                            @csrf
                            @method('delete')
                            <button class="delete" type="submit" onclick="return confirm('このメッセージを削除しますか？')">削除</button>
                        </form>
                    </div>
                    @endif
                </div>
                @endforeach
            </div>

            <div class="message">
                <div class="message___form">
                    <form action="{{route('message.store', ['trade' => $trade->id])}}" method="post" enctype="multipart/form-data">
                        @csrf
                        @if((!empty($trade->buyer_completed_at)))
                            <textarea class="form__textarea" name="comment" id="draft_message_main" placeholder="コメントできません" disabled></textarea>
                        @else
                            <textarea class="form__textarea" name="comment" id="draft_message_main" placeholder="取引メッセージを記入してください" ></textarea>
                        @endif
                        <label for="image" class="img__upload">画像を追加</label>
                        <input type="file" name="img_url" id="image" hidden>
                        <button class="send__btn" type="submit">
                            <img src="/images/メッセージ送信.jpg" alt="送信ボタン">
                        </button>
                    </form>
                    @error('comment')
                    <p class="error-message">{{ $message }}</p>
                    @enderror
                    @error('img_url')
                    <p class="error-message">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>
    </div>
</div>
@include('chat.modal.review')
<script>
    //購入者のレビューのモーダル
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
    document.addEventListener('DOMContentLoaded', function() {
        //取得するデータtextareaのidと一致
        const textarea = document.getElementById('draft_message_main');
        // 取引ごとに分ける
        const key = 'draft_message_{{ $trade->id }}';
        // 保存されている下書きを復元
        const saved = localStorage.getItem(key);
        if (saved) {
            textarea.value = saved;
        }
        // 入力するたびに保存
        textarea.addEventListener('input', function() {
            localStorage.setItem(key, textarea.value);
        });
        // 送信したら削除
        const form = textarea.closest('form');
        if (form) {
            form.addEventListener('submit', function() {
                localStorage.removeItem(key);
            });
        }
    });

</script>

@if($showSellerReviewModal)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const modal = document.getElementById('reviewModal');
        if (modal) {
            modal.classList.add('is-open');
        }
    });
</script>
@endif
@endsection

