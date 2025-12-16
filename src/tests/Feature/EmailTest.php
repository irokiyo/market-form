<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Notification;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\URL;

class EmailTest extends TestCase
{
    use RefreshDatabase;

    //会員登録後、認証メールが送信される
    public function test_email_is_sent_after_registration()
    {
        Notification::fake();

        $response = $this->post(route('register'), [
            'name'                  => 'テストユーザー',
            'email'                 => 'test@example.com',
            'password'              => 'password123',
            'password_confirmation' => 'password123',
        ]);

        // 会員登録後に認証案内画面などにリダイレクトしている想定
        // 実装に応じて route 名は調整してください（例：route('verification.notice') / route('index') など）
        $response->assertStatus(302);

        $user = User::where('email', 'test@example.com')->first();
        $this->assertNotNull($user);

        // 登録したユーザー宛に VerifyEmail 通知が送られていること
        Notification::assertSentTo($user, VerifyEmail::class);
    }

    //メール認証誘導画面で「認証はこちらから」ボタンを押下するとメール認証サイトに遷移する
    public function test_verification_notice_page_shows_button_to_verify()
    {
        $user = User::factory()->unverified()->create();

        // 認証案内画面を表示
        $response = $this->actingAs($user)
            ->get(route('verification.notice'));

        $response->assertStatus(200);

        // 誘導ボタンの文言が表示されていること
        $response->assertSee('認証はこちらから');

        // 実装によっては、メール認証用の URL へのリンクが含まれているかをチェックしてもOK
        // 例）$response->assertSee(route('verification.notice')); など
    }

    //メール認証サイトのメール認証を完了すると、プロフィール設定画面に遷移する
    public function test_email_verification_redirects_to_profile_page()
    {
        $user = User::factory()->unverified()->create();

        // Laravel 標準の検証リンクと同じ形式の署名付きURLを生成
        $verificationUrl = URL::temporarySignedRoute(
            'verification.verify',
            now()->addMinutes(60),
            [
                'id'   => $user->id,
                'hash' => sha1($user->email),
            ]
        );

        // メールのリンクをクリックした想定でアクセス
        $response = $this->actingAs($user)->get($verificationUrl);

        // プロフィール設定画面にリダイレクトされる想定
        // プロフィール設定のルート名に合わせて変更してください
        // 例）route('profile.show') / route('mypage') など
        $response->assertRedirect(route('profile.show'));

        // ユーザーのメール認証フラグがONになっていること
        $this->assertTrue($user->fresh()->hasVerifiedEmail());
    }


}
