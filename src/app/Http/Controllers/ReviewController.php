<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use App\Models\Trade;
use App\Notifications\TransactionCompleted;

class ReviewController extends Controller
{
    public function store(ReviewRequest $request, Trade $trade)
    {
        $alreadyReview = Review::where('trade_id', $trade->id)
            ->where('reviewer_id', auth()->id())
            ->exists();

        if ($alreadyReview) {
            return redirect()->route('index')->with('error', 'すでにレビュー済みです');
        }

        $reviewee = auth()->id() === $trade->buyer->id
            ? $trade->seller
            : $trade->buyer;

        $review = [
            'trade_id' => $trade->id,
            'reviewer_id' => auth()->id(),
            'reviewee_id' => $reviewee->id,
            'rating' => $request->rating,
            'comment' => null,
        ];
        Review::create($review);

        if (auth()->id() === $trade->buyer->id) {
            $trade->update([
                'buyer_completed_at' => now(),
            ]);

            $trade->seller->notify(new TransactionCompleted($trade));
        }

        return redirect()->route('index')->with('success', 'レビューを送信しました');
    }

    public function sellerStore(ReviewRequest $request, Trade $trade)
    {
        $review = [
            'trade_id' => $trade->id,
            'reviewer_id' => auth()->id(),
            'reviewee_id' => $trade->buyer->id,
            'rating' => $request->rating,
            'comment' => null,
        ];
        Review::create($review);

        if (auth()->id() === $trade->seller->id) {
            $trade->update([
                'status' => Trade::STATUS_COMPLETED,
                'seller_reviewed_at' => now()
            ]);
        }

        return redirect()->route('index')->with('success', '取引が完了しました');
    }
}
