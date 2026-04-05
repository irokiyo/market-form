<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Trade extends Model
{
    use HasFactory;

    public const STATUS_IN_PROGRESS = 'in_progress';
    public const STATUS_COMPLETED = 'completed';
    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable =
        [
            'buyer_id',
            'seller_id',
            'item_id',
            'status',
            'buyer_completed_at',
            'seller_reviewed_at',
        ];


    public function buyer()
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }
    public function seller()
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }
}
