<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Profile;
use App\Models\Item;
use App\Models\Order;
use App\Models\PaymentMethod;

class UserInformationTest extends TestCase
{
    use RefreshDatabase;

    public function testMypageDisplaysProfileAndItemsAndOrders()
    {
        $user = User::factory()->create();

        Profile::create([
            'user_id'  => $user->id,
            'name'     => 'テストユーザー',
            'postcode' => '111-1111',
            'address'  => 'テスト県テスト市',
            'building' => 'テストビル101',
            'img_url'  => null,
        ]);

        $sellItem = Item::factory()->create([
            'user_id' => $user->id,
            'name'    => '出品した商品A',
        ]);

        $otherSeller = User::factory()->create();
        $buyItem = Item::factory()->create([
            'user_id' => $otherSeller->id,
            'name'    => '購入した商品B',
        ]);

        $paymentMethod = PaymentMethod::create([
            'payment_method' => 'クレジットカード',
        ]);

        Order::create([
            'user_id'           => $user->id,
            'item_id'           => $buyItem->id,
            'payment_method_id' => $paymentMethod->id,
            'postcode'          => '222-2222',
            'address'           => '購入先住所',
            'building'          => '購入ビル202',
        ]);

        $response = $this->actingAs($user)
            ->get(route('mypage', ['page' => 'sell']));

        $response->assertStatus(200);

        $response->assertSee('テストユーザー');
        $response->assertSee('出品した商品A');
        $response->assertSee('購入した商品B');
    }

    public function testProfileEditPageShowsInitialValues()
    {
        $user = User::factory()->create();

        Profile::create([
            'user_id'  => $user->id,
            'name'     => '初期ユーザー名',
            'postcode' => '123-4567',
            'address'  => '東京都テスト区テスト町',
            'building' => 'テストマンション303',
            'img_url'  => 'profiles/test.png',
        ]);

        $response = $this->actingAs($user)
            ->get(route('profile.show'));

        $response->assertStatus(200);

        $response->assertSee('初期ユーザー名');
        $response->assertSee('123-4567');
        $response->assertSee('東京都テスト区テスト町');
        $response->assertSee('テストマンション303');
    }
}
