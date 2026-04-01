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
        $messages = $trade->messages;


        return view('chat.show', compact(
            'trade',
            'messages'
        ));
    }
}
