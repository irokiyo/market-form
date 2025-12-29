<?php

namespace Tests\Feature;

use App\Models\Item;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SearchTest extends TestCase
{
    use RefreshDatabase;

    //一部検索
    public function testPartsOfSearchItems()
    {
        Item::factory()->create(['name' => 'りんご']);
        Item::factory()->create(['name' => 'バナナ']);

        $response = $this->get(route('index', ['keyword' => 'りん']));

        $response->assertStatus(200);
        $response->assertSee('りんご');
        $response->assertDontSee('バナナ');
    }

    // 検索状態がマイリストでも保持されている
    public function testSearchKeywordIsKerping()
    {
        $user = User::factory()->create();

        $response = $this->actingAs($user)->get(route('index', ['keyword' => 'りんご']));

        $response->assertStatus(200);

        $expectedUrl = route('index', ['tab' => 'mylist', 'keyword' => 'りんご']);
        $response->assertSee($expectedUrl);
    }
}
