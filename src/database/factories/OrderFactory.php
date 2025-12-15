<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use App\Models\Item;
use App\Models\PaymentMethod;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id'           => User::factory(),
            'item_id'           => Item::factory(),
            'payment_method_id' => PaymentMethod::factory(),
            'postcode'          => '123-4567',
            'address'           => 'テスト県テスト市1-2-3',
            'building'          => 'テストビル101',
        ];
    }
}
