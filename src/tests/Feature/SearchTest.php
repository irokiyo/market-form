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
    public function test_parts_of_search_items()
    {
        Item::factory()->create(['name' => 'りんご']);
        Item::factory()->create(['name' => 'バナナ']);

        $response = $this->get(route('search', ['keyword' => 'りん']));

        $response->assertStatus(200);

        $response->assertSee('りんご');
        $response->assertDontSee('バナナ');
    }

    // 検索状態がマイリストでも保持されている
    public function test_search_keyword_is_kerping()
    {
        $user =User::factory()->create();

        $response = $this->actingAs($user)->get(route('search', ['keyword' => 'りんご']));

        $response->assertStatus(200);

        $expectedUrl = route('search', ['tab' => 'mylist', 'keyword' => 'りんご']);
        $response->assertSee($expectedUrl);
    }
}
