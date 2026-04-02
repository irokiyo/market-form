<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Models\Trade;

class MessageController extends Controller
{
    public function store(MessageRequest $request,Trade $trade)
    {
        $receiver = auth()->id()===$trade->buyer_id
            ? $trade->seller_id
            : $trade->buyer_id;

        $imagePath=null;
        if($request->hasFile('img_url')){
            $imagePath->file('img_url')->store('message', 'public');
        }

        $messages = Message::create([
            'user_id'=>auth()->id(),
            'receiver_id'=>$receiver,
            'trade_id'=>$trade->id,
            'comment'=>$request->comment,
            'image_url'=>$imagePath,
            'read'=>false,
        ]);


        return redirect()->back()->with('success', '送信しました');
    }
}
