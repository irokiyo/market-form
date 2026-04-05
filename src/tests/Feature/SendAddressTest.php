<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Profile;
use App\Models\PaymentMethod;

class SendAddressTest extends TestCase
{
    use RefreshDatabase;

    /**
     * 送付先住所変更画面にて登録した住所が商品購入画面に反映されている
     */
    public function testChangedAddressIsReflectedOnPurchasePage()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // プロフィール（デフォルト住所）を作成
        Profile::create([
            'user_id'  => $user->id,
            'name'     => 'テストユーザー',
            'postcode' => '111-1111',
            'address'  => '元の住所',
            'building' => '元のビル101',
            'img_url'  => null,
        ]);

        // 住所変更画面から新しい住所を登録（セッションに保存される想定）
        $this->actingAs($user)->post(route('address.update', $item->id), [
            'postcode' => '999-9999',
            'address'  => 'テスト市テスト町',
            'building' => 'テストビル999',
        ]);

        // 商品購入画面を再度開く
        $response = $this->actingAs($user)
            ->get(route('purchase', $item->id));

        $response->assertStatus(200);

        // 購入画面上に新しい住所が表示されていること
        $response->assertSee('999-9999');
        $response->assertSee('テスト市テスト町');
        $response->assertSee('テストビル999');
    }

    public function testOrderIsSavedWithShippingAddress()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        // 支払い方法
        $paymentMethod = PaymentMethod::create([
            'payment_method' => 'クレジットカード',
        ]);

        // 住所変更画面で入力した想定の住所
        $postcode = '123-4567';
        $address  = '東京都テスト区テスト町';
        $building = 'テストマンション101';

        // 住所変更画面で登録（セッションに保存される想定）
        $this->actingAs($user)->post(route('address.update', $item->id), [
            'postcode' => $postcode,
            'address'  => $address,
            'building' => $building,
        ]);

        // 購入処理を実行（PurchaseRequest で必須の項目を渡す）
        $response = $this->actingAs($user)
            ->post(route('purchase.store', $item->id), [
                'payment_method' => $paymentMethod->id,
                'postcode'       => $postcode,
                'address'        => $address,
                'building'       => $building,
            ]);

        $response->assertStatus(302);

        // orders テーブルに送付先住所が紐づいて保存されていること
        $this->assertDatabaseHas('orders', [
            'user_id'  => $user->id,
            'item_id'  => $item->id,
            'postcode' => $postcode,
            'address'  => $address,
            'building' => $building,
        ]);
    }
}
