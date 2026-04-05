<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\Item;
use App\Models\Category;

class ShowItemTest extends TestCase
{
    use RefreshDatabase;


    //すべての情報が商品詳細ページに表示されている
    public function testItemDisplay()
    {
        $item = Item::factory()->create([
            'name'        => 'テスト商品',
            'brand'       => 'テストブランド',
            'price'       => 3000,
            'condition'      => '新品',
            'description' => 'テスト商品の説明です。',
        ]);

        $response = $this->get(route('show', $item->id));

        $response->assertStatus(200)
            ->assertSee('テスト商品')
            ->assertSee('テストブランド')
            ->assertSee('3000')
            ->assertSee('新品')
            ->assertSee('テスト商品の説明です。');
    }
    //複数選択されたカテゴリが商品詳細ページに表示されている
    public function testSelectedCategoriesDisplay()
    {
        $item = Item::factory()->create([
            'name' => 'カテゴリテスト商品',
        ]);

        $category1 = Category::factory()->create(['category' => 'ファッション']);
        $category2 = Category::factory()->create(['category' => '家電']);

        $item->categories()->attach([$category1->id, $category2->id]);

        $response = $this->get(route('show', $item->id));

        $response->assertStatus(200)
            ->assertSee('ファッション')
            ->assertSee('家電');
    }
}
