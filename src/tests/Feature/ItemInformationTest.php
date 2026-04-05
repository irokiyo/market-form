<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;
use App\Models\User;
use App\Models\Category;
use App\Models\Item;

class ItemInformationTest extends TestCase
{
    use RefreshDatabase;

    public function testSellItemStore()
    {
        Storage::fake('public');

        $user = User::factory()->create();

        $category1 = Category::create(['category' => 'ファッション']);
        $category2 = Category::create(['category' => '家電']);

        $file = UploadedFile::fake()->create('test.jpg', 100, 'image/jpeg');

        $response = $this->actingAs($user)->post(route('sell.create'), [
            'name'        => 'テスト商品',
            'brand'       => 'テストブランド',
            'price'       => 5000,
            'description' => 'テスト説明文です',
            'condition'   => '新品',
            'img_url'     => $file,
            'categories'  => [$category1->id, $category2->id],
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('mypage'));

        $this->assertDatabaseHas('items', [
            'name'        => 'テスト商品',
            'brand'       => 'テストブランド',
            'price'       => 5000,
            'description' => 'テスト説明文です',
            'condition'   => '新品',
            'user_id'     => $user->id,
        ]);

        $item = Item::first();
        Storage::disk('public')->assertExists($item->img_url);

        $this->assertCount(2, $item->categories);
    }
}
