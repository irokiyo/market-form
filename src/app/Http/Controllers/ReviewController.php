<?php

namespace App\Http\Controllers;

use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use App\Models\Trade;
use App\Notifications\TransactionCompleted;

class ReviewController extends Controller
{
    public function store(ReviewRequest $request,Trade $trade)
    {
        $reviewee =auth()->id()===$trade->buyer->id
            ? $trade->seller
            : $trade->buyer;

        $review = [
            'trade_id'=>$trade->id,
            'reviewer_id'=> auth()->id(),
            'reviewee_id' =>$reviewee->id,
            'rating'=>$request->rating,
            'comment'=>null,
        ];
        Review::create($review);

        $trade->update([
                'status'=>Trade::STATUS_COMPLETED,
            ]);

        if(auth()->id()===$trade->buyer->id){
            $trade->seller->notify(new TransactionCompleted($trade));
        }

        return redirect()->route('index')->with('success', '取引が完了しました');;
    }
}
