<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable =
    [
        'user_id',
        'img_url',
        'condition',
        'name',
        'brand',
        'price',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class,'user_id');
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_items');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    public function favoriteUsers()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }
    public function liked()
    {
    return auth()->check()
        && auth()->user()->favorites()->where('item_id', $this->id)->exists();
    }

}
