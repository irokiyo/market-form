<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ItemListTest extends TestCase
{
    use RefreshDatabase;

    //全商品の表示
    public function testAllItemList()
    {
        $items = Item::factory()->count(6)->create();

        $response = $this->get(route('index'));

        $response->assertStatus(200);

        foreach ($items as $item) {
            $response->AssertSee($item->name);
        }
    }

    //購入済みの商品にsoldがついている
    public function testSoldItemList()
    {
        $item = Item::factory()->create();
        $user = User::factory()->create();
        $paymentMethod = PaymentMethod::factory()->create();

        Order::create([
        'user_id'           => $user->id,
        'item_id'           => $item->id,
        'payment_method_id' => $paymentMethod->id,
        'postcode'          => '123-4567',
        'address'           => 'テスト県テスト市1-2-3',
        'building'          => 'テストビル101',
        ]);

        $response = $this->get(route('index'));

        $response->AssertSee('Sold');
    }
    //自分が出品した商品は表示されない
    public function testMyItemList()
    {
        $user = User::factory()->create();

        $myItem = Item::factory()->create([
            'user_id' => $user->id,
            'name'    => 'MY_TEST_ITEM_SHOULD_NOT_APPEAR',
        ]);
        $otherItems = Item::factory(3)->create();

        $response = $this->actingAs($user)-> get(route('index'));

        $response->assertStatus(200);

        $response->assertDontSee('MY_TEST_ITEM_SHOULD_NOT_APPEAR');
        foreach ($otherItems as $item) {
            $response->assertSee($item->name);
        }
    }
}
