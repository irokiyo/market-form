<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\MessageRequest;
use App\Models\Message;
use App\Models\Trade;

class MessageController extends Controller
{
    public function store(MessageRequest $request, Trade $trade)
    {
        $receiver = auth()->id() === $trade->buyer_id
            ? $trade->seller_id
            : $trade->buyer_id;

        $imagePath = null;
        if ($request->hasFile('img_url')) {
            $imagePath = $request->file('img_url')->store('message_images', 'public');
        }

        $messages = Message::create([
            'user_id' => auth()->id(),
            'receiver_id' => $receiver,
            'trade_id' => $trade->id,
            'comment' => $request->comment,
            'image_url' => $imagePath,
            'read' => false,
        ]);


        return redirect()->back()->with('success', '送信しました');
    }

    public function update(MessageRequest $request, Trade $trade, Message $message)
    {
        $imagePath = $message->image_url;

        if ($request->hasFile('img_url')) {
            $imagePath = $request->file('img_url')->store('message_images', 'public');
        }
        $message->update([
            'comment' => $request->comment,
            'image_url' => $imagePath,
        ]);

        return redirect()->route('chat.show', ['trade' => $trade->id])->with('success', '更新しました');
    }

    public function delete(Request $request, Trade $trade, Message $message)
    {
        $message->delete();

        return redirect()->back()->with('success', '削除しました');
    }
}
