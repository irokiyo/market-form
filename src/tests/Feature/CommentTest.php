<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;
use App\Models\Comment;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    // ログイン済みのユーザーはコメントを送信できる
    public function test_user_can_send_comment()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('comment.create', $item->id), [
                'comment' => 'テストコメントです。',
            ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('comments', [
            'user_id' => $user->id,
            'item_id' => $item->id,
            'comment' => 'テストコメントです。',
        ]);
    }

    // ログイン前のユーザーはコメントを送信できない
    public function test_guest_user_cannot_send_comment()
    {
        $item = Item::factory()->create();

        $response = $this->post(route('comment.create', $item->id), [
            'comment' => 'ゲストのコメント',
        ]);

        $response->assertStatus(302);
        $response->assertRedirect(route('login'));

        $this->assertDatabaseMissing('comments', [
            'comment' => 'ゲストのコメント',
        ]);
    }

    // コメントが入力されていない場合、バリデーションメッセージが表示される
    public function test_empty_comment_shows_validation_error()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $response = $this->actingAs($user)
            ->post(route('comment.create', $item->id), [
                'comment' => '',
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('comment');

        $this->assertDatabaseCount('comments', 0);
    }


    // コメントが255字以上の場合、バリデーションメッセージが表示される
    public function test_too_long_comment_shows_validation_error()
    {
        $user = User::factory()->create();
        $item = Item::factory()->create();

        $longComment = str_repeat('あ', 260); // 255文字超え

        $response = $this->actingAs($user)
            ->post(route('comment.create', $item->id), [
                'comment' => $longComment,
            ]);

        $response->assertStatus(302);
        $response->assertSessionHasErrors('comment');

        $this->assertDatabaseCount('comments', 0);
    }

}
