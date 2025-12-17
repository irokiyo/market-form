<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\PaymentMethod;
use App\Models\Profile;

class PaymentMethodTest extends TestCase
{
    use RefreshDatabase;

    // 支払い方法選択画面で、支払い方法の選択肢が反映される
    public function testPaymentMethods()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Profile::create([
        'user_id' => $user->id,
        'name' => 'テストユーザー',
        'postcode' => '123-4567',
        'address' => '東京都テスト市',
        'building' => 'テストビル101',
        'img_url' => null,
        ]);

        $method1 = PaymentMethod::create([
            'payment_method' => 'クレジットカード',
        ]);

        $method2 = PaymentMethod::create([
            'payment_method' => 'コンビニ払い',
        ]);

        $response = $this->actingAs($user)
            ->get(route('purchase', $item->id));

        $response->assertStatus(200);

        $response->assertSee('クレジットカード');
        $response->assertSee('コンビニ払い');
    }
}
