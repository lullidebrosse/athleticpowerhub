<?php

namespace Tests\Feature\Auth;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_valid_credentials()
    {
        // 1. Arrange: Create a test user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        // 2. Act: Attempt to login
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123'
        ]);

        // 3. Assert: Check if login was successful
        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
    }

    public function test_user_cannot_login_with_invalid_credentials()
    {
        // 1. Arrange: Create a test user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        // 2. Act: Attempt to login with wrong password
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'wrongpassword'
        ]);

        // 3. Assert: Check if login failed
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_cannot_login_with_empty_credentials()
    {
        // 1. Act: Attempt to login with empty credentials
        $response = $this->post('/login', [
            'email' => '',
            'password' => ''
        ]);

        // 2. Assert: Check for validation errors
        $response->assertSessionHasErrors(['email', 'password']);
        $this->assertGuest();
    }

    public function test_user_cannot_login_with_invalid_email_format()
    {
        // 1. Act: Attempt to login with invalid email format
        $response = $this->post('/login', [
            'email' => 'invalid-email',
            'password' => 'password123'
        ]);

        // 2. Assert: Check for email validation error
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_cannot_login_with_nonexistent_email()
    {
        // 1. Act: Attempt to login with non-existent email
        $response = $this->post('/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'password123'
        ]);

        // 2. Assert: Check for authentication error
        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    public function test_user_can_login_with_remember_me()
    {
        // 1. Arrange: Create a test user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        // 2. Act: Attempt to login with remember me checked
        $response = $this->post('/login', [
            'email' => 'test@example.com',
            'password' => 'password123',
            'remember' => true
        ]);

        // 3. Assert: Check if remember me token was created
        $response->assertRedirect('/dashboard');
        $this->assertAuthenticated();
        $this->assertNotNull($user->fresh()->remember_token);
    }

    public function test_user_is_rate_limited_after_too_many_attempts()
    {
        // 1. Arrange: Create a test user
        $user = User::factory()->create([
            'email' => 'test@example.com',
            'password' => bcrypt('password123')
        ]);

        // 2. Act: Attempt to login multiple times with wrong password
        for ($i = 0; $i < 6; $i++) {
            $response = $this->post('/login', [
                'email' => 'test@example.com',
                'password' => 'wrongpassword'
            ]);
        }

        // 3. Assert: Check for rate limiting
        $response->assertStatus(429);
        $this->assertGuest();
    }
} 