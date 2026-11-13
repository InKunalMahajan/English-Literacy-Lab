<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_redirected_from_dashboard(): void
    {
        $this->get('/dashboard')->assertRedirect('/login');
    }

    public function test_login_page_is_available(): void
    {
        $this->get('/login')->assertOk()->assertSee('Sign in');
    }

    public function test_active_user_can_log_in_and_log_out(): void
    {
        $user = User::create([
            'name' => 'Example Educator',
            'email' => 'educator@example.test',
            'password' => 'correct-horse-password',
            'is_active' => true,
        ]);

        $this->post('/login', [
            'email' => $user->email,
            'password' => 'correct-horse-password',
        ])->assertRedirect('/dashboard');

        $this->assertAuthenticatedAs($user);
        $this->post('/logout')->assertRedirect('/');
        $this->assertGuest();
    }

    public function test_inactive_user_cannot_log_in(): void
    {
        User::create([
            'name' => 'Inactive User',
            'email' => 'inactive@example.test',
            'password' => 'correct-horse-password',
            'is_active' => false,
        ]);

        $this->post('/login', [
            'email' => 'inactive@example.test',
            'password' => 'correct-horse-password',
        ])->assertSessionHasErrors('email');

        $this->assertGuest();
    }
}
