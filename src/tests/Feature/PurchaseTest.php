<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Order;
use App\Models\PaymentMethod;

class PurchaseTest extends TestCase
{
    use RefreshDatabase;

     //購入する」ボタンを押下すると購入が完了する
    public function test_user_can_purchase_item()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $paymentMethod = PaymentMethod::create([
            'payment_method' => 'クレジットカード',
        ]);

        $response = $this->actingAs($user)
            ->post(route('purchase.store', $item->id), [
                'payment_method' => $paymentMethod->id,
                'postcode'       => '123-4567',
                'address'        => '東京都テスト市1-2-3',
                'building'       => 'テストビル101',
            ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'payment_method_id' => $paymentMethod->id,
        ]);
    }


    //購入した商品は商品一覧画面にて「sold」と表示される
    public function test_purchased_item_sold_on()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $paymentMethod = PaymentMethod::create([
            'payment_method' => 'クレジットカード',
        ]);

        Order::create([
            'user_id'           => $user->id,
            'item_id'           => $item->id,
            'payment_method_id' => $paymentMethod->id,
            'postcode'          => '123-4567',
            'address'           => '東京都テスト市1-2-3',
            'building'          => 'テストビル101',
        ]);

        $response = $this->actingAs($user)
            ->get(route('index'));

        $response->assertStatus(200);

        $response->assertSee('Sold');
    }

    //プロフィール/購入した商品一覧」に追加されている
    public function test_purchased_item_is_listed_in()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create([
            'name' => '購入テスト商品',
        ]);

        $paymentMethod = PaymentMethod::create([
            'payment_method' => 'クレジットカード',
        ]);

        Order::create([
            'user_id'           => $user->id,
            'item_id'           => $item->id,
            'payment_method_id' => $paymentMethod->id,
            'postcode'          => '123-4567',
            'address'           => '東京都テスト市1-2-3',
            'building'          => 'テストビル101',
        ]);

        $response = $this->actingAs($user)
        ->get(route('mypage', ['page' => 'buy']));

        $response->assertSee('購入テスト商品');
    }
}
