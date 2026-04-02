<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable =
        [
            'user_id',
            'receiver_id',
            'trade_id',
            'comment',
            'image_url',
            'read',
        ];
    public function isMine()
    {
        return $this->user_id === auth()->id();
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    public function trade()
    {
        return $this->belongsTo(Trade::class, 'trade_id');
    }

}
