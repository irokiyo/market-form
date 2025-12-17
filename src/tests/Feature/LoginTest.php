<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    private function _validData(array $overrides = []): array
    {
        return array_merge([
            'email' => 'test@example.com',
            'password' => 'password',
        ], $overrides);
    }

    //emailのバリデーション
    /** @test */
    public function testLoginEmailValidation()
    {
        $response = $this->from(route('login'))
            ->post(route('login'), $this->_validData([
                'email' => '',
            ]));

        $response->assertRedirect(route('login'));

        $response->assertSessionHasErrors([
            'email' => 'メールアドレスを入力してください',
        ]);
    }

    //passwordのバリデーション
    public function testLoginPasswordValidation()
    {
        $response = $this->from(route('login'))
            ->post(route('login'), $this->_validData([
                'password' => '',
            ]));

        $response->assertRedirect(route('login'));

        $response->assertSessionHasErrors([
            'password' => 'パスワードを入力してください',
        ]);
    }

    //入力情報が違うときのバリデーション
    public function testLoginMismatchValidation()
    {
        User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
        ]);

        $response = $this->from(route('login'))
            ->post(route('login'), $this->_validData([
                'email' => '123@example.com',
                'password' => 'pass',
            ]));

        $response->assertRedirect(route('login'));

        $response->assertSessionHasErrors([
            'email'   => 'ログイン情報が登録されていません',
        ]);
    }

    //ログイン処理の実施
    public function testSuccessLogin()
    {
        User::factory()->create([
        'email' => 'test@example.com',
        'password' => bcrypt('password'),
        ]);

        $response = $this->post(route('login'), $this->_validData([
            ]));

        $this->assertAuthenticated();

        $response->assertRedirect('/');
    }
}
