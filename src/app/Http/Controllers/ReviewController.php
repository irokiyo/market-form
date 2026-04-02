<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\ReviewRequest;
use App\Models\Review;
use App\Models\Trade;

class ReviewController extends Controller
{
    public function store(ReviewRequest $request,Trade $trade)
    {
        $reviewee =auth()->id()===$trade->buyer->id
            ? $trade->seller_id
            : $trade->buyer_id;

        $review = [
            'trade_id'=>$trade->id,
            'reviewer_id'=> auth()->id(),
            'reviewee_id' =>$reviewee,
            'rating'=>$request->rating,
            'comment'=>null,
        ];
        Review::create($review);

        $trade->update([
                'status'=>Trade::STATUS_COMPLETED,
            ]);


        return redirect()->route('index');
    }
}
