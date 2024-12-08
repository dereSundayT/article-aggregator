<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AuthenticationApiControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test user registration.
     *
     * @return void
     */
    public function test_user_can_register()
    {
        $email = $this->faker->safeEmail;
        $response = $this->postJson('/api/v1/auth/register', [
            'name' => $this->faker->name,
            'email' => $email,
            'password' => 'Pass@125?',
            'password_confirmation' => 'Pass@125?',
        ]);

        $response->assertStatus(201)
            ->assertJson([
                'message' => 'User created successfully',
            ]);

        $this->assertDatabaseHas('users', [
            'email' => $email,
        ]);
    }

    /**
     * Test user login.
     *
     * @return void
     */
    public function test_user_can_login()
    {
        $user = User::factory()->create([
            'password' => bcrypt($password = 'password'),
        ]);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Login successful',
            ]);
    }
}
