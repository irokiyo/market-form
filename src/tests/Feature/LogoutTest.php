<?php

namespace Tests\Feature;

use App\Models\User;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    public function testLogout()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password'),
        ]);

        $this->actingAs($user);

        $response = $this->post(route('logout'));

        $this->assertGuest();

        $response->assertRedirect((route('index')));
    }
}
