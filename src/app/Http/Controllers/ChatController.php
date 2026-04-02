<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Item;
use App\Models\User;
use App\Models\Trade;
use App\Models\Message;
use App\Models\Review;

class ChatController extends Controller
{
    public function show(Trade $trade)
    {
        Message::where('receiver_id', auth()->id())
            ->where('trade_id',$trade->id)
            ->where('read', false)
            ->update(['read'=>true]);
        
        $user = auth()->id();
        $messages = $trade->messages;
        $trades = Trade::with('item')
            ->where('buyer_id', $user)
            ->orWhere('seller_id', $user)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('chat.show', compact(
            'trade',
            'trades',
            'messages'
        ));
    }
}
