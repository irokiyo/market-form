<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\User;
use App\Models\Item;

class CommentTest extends TestCase
{
    use RefreshDatabase;

    // ログイン済みのユーザーはコメントを送信できる
    public function testUserCanSendComment()
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
    public function testGuestUserCannotSendComment()
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
    public function testEmptyCommentShowsValidationError()
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
    public function testTooLongCommentShowsValidationError()
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
