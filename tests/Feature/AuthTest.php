<?php

namespace Tests\Feature;

use App\Models\Auth\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

/**
 * @internal
 * @covers \App\Http\Controllers\Auth\LoginController
 */
class AuthTest extends TestCase
{
    use RefreshDatabase;
    use WithFaker;

    public function testLogin(): void
    {
        $this->get('/async/user')
            ->assertUnauthorized();

        $user = User::factory()->make();
        $user->save();

        $this->post('/async/login', ['email' => $user->email, 'password' => 'password'])
            ->assertOk()
            ->assertCookie('laravel_session');

        $this->get('/async/user')
            ->assertOk()
            ->assertJson([
                'id'          => $user->id,
                'name'        => $user->name,
                'permissions' => [],
            ]);
    }

    public function testLogout(): void
    {
        $this->post('/async/logout')
            ->assertUnauthorized();

        $user = User::factory()->make();
        $user->save();

        $this->actingAs($user);

        $this->post('/async/logout')
            ->assertNoContent();

        $this->get('/async/user')
            ->assertUnauthorized();
    }
}
