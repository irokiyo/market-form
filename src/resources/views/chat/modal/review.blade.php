<div class="modal__review" id="reviewModal">
    <form id="reviewForm" action="{{$showSellerReviewModal
            ?route('review.seller.store',['trade' => $trade->id])
            :route('review.store',['trade' => $trade->id])}}" class="form__review" method="post">
        @csrf
        <div class="modal__card">
            <div class="card__part">
                <h1 class="message">取引が完了しました。</h1>
            </div>
            <div class="card__part">
                <p class="review__cmt">今回の取引相手はどうでしたか？</p>
                <div class="rating">
                    <input type="radio" name="rating" id="star5" value="5" hidden>
                    <label for="star5" class="review-star">★</label>
                    <input type="radio" name="rating" id="star4" value="4" hidden>
                    <label for="star4" class="review-star">★</label>
                    <input type="radio" name="rating" id="star3" value="3" hidden>
                    <label for="star3" class="review-star">★</label>
                    <input type="radio" name="rating" id="star2" value="2" hidden>
                    <label for="star2" class="review-star">★</label>
                    <input type="radio" name="rating" id="star1" value="1" hidden>
                    <label for="star1" class="review-star">★</label>
                </div>
                @error('rating')
                <p class="error-message">{{ $message }}</p>
                @enderror
            </div>
            <div class="card__part">
                <button type="submit" class="submit_btn" form="reviewForm">送信する</button>
            </div>
        </div>
    </form>
</div>

