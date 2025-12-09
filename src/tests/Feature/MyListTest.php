<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use App\Models\Order;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class MyListTest extends TestCase
{
    use RefreshDatabase;

    //購入済み商品はsoldと出る
    public function test_sold_item__list()
    {
        $item = Item::factory()->create();
        $user = User::factory()->create();

        Order::factory()->create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->get(route('index'));

        $response->AssertSee('Sold');
    }
    //未認証の場合は表示されない
    public function test_no_login_item__list()
    {
        $response = $this->get(route('index'));

        $response->assertGuest();
    }
}
