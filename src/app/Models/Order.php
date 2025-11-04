<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'user_id',
        'item_id',
        'payment_method_id',
        'postcode',
        'address',
        'building',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class,'item_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function paymentMethod()
    {
        return $this->belongsTo(PaymentMethod::class,'payment_method_id');
    }
}
