<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    //いいねした商品のみ見れる
    public function test_favorite_items()
    {
        $user = User::factory()->create();

        $items = [
            Item::factory()->create(['name' => 'FAVORITED_ITEM']),
            Item::factory()->create(['name' => 'OTHER_ITEM_1']),
            Item::factory()->create(['name' => 'OTHER_ITEM_2']),
        ];

        $user->favorites()->attach($items[0]->id);

        $response = $this->actingAs($user)->get('/search?tab=mylist');

        $response->assertSee('FAVORITED_ITEM');


    }

    //購入済み商品はsoldと出る
    public function test_sold_item__list()
    {
        $item = Item::factory()->create();
        $user = User::factory()->create();
        $payment = PaymentMethod::factory()->create();

        $user->favorites()->attach($item->id);

        Order::factory()->create([
            'user_id'           => $user->id,
            'item_id'           => $item->id,
            'payment_method_id' => $payment->id,
            'postcode'          => '123-4567',
            'address'           => 'テスト県テスト市1-2-3',
            'building'          => 'テストビル101',
        ]);

        $response = $this->actingAs($user)->get('/search?tab=mylist');

        $response->AssertSee('Sold');
    }
    //未認証の場合は表示されない
    public function test_no_login_item__list()
    {
        $response = $this->get('/search?tab=mylist');

        $response->assertStatus(200);
    }
}
