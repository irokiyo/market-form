<?php

namespace App\Notifications;

use App\Models\Trade;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TransactionCompleted extends Notification
{
    use Queueable;

    protected $trade;

    public function __construct(Trade $trade)
    {
        $this->trade = $trade;
    }

    // 通知を送信するチャンネル（メール、データベース等）
    public function via($notifiable)
    {
        return ['mail'];//メールだけ
    }

    // メール通知の内容
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('取引完了のご報告')
                    ->line('取引が完了しました。')
                    ->action('取引詳細を見る', route('chat.show', ['trade' => $this->trade->id]))
                    ->line('ご利用ありがとうございました。');
    }

    //データベース側の方
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
