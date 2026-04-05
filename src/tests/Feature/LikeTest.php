<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Favorite;

class LikeTest extends TestCase
{
    use RefreshDatabase;

    //いいねした商品として登録され、いいね合計値が増加表示される
    public function testUserFavoriteItem()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('favorite', $item->id));

        $response->assertStatus(302);

        $this->assertDatabaseHas('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }

    //いいねアイコンが押下された状態では色が変化する
    public function testFavoriteIconColorChange()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Favorite::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)
            ->get(route('show', $item->id));

        $response->assertStatus(200);

        $response->assertSee('/images/ハートロゴ_ピンク.png');
    }

    //いいねが解除され、いいね合計値が減少表示される
    public function testUserCanUnfavoriteItem()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        Favorite::create([
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);

        $response = $this->actingAs($user)
            ->post(route('favorite', $item->id));

        $response->assertStatus(302);

        $this->assertDatabaseMissing('favorites', [
            'user_id' => $user->id,
            'item_id' => $item->id,
        ]);
    }
}
