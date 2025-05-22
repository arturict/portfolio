<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
// UserResource is not directly asserted by structure here, but the fields match its typical output.
// If UserResource wraps data under a 'data' key, assertJsonStructure(['data' => ...]) is correct.

class FeatureUserAuthenticationTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /**
     * Test user registration with valid data.
     *
     * @return void
     */
    public function test_user_can_register()
    {
        $userData = [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ];

        $response = $this->postJson('/api/register', $userData);

        $response->assertStatus(201) // UserController returns HTTP 200 for UserResource::make($user)
            ->assertJsonStructure([ // Assuming UserResource wraps in 'data' by default
                'data' => ['id', 'name', 'email']
            ]);

        $this->assertDatabaseHas('users', [
            'name' => $userData['name'],
            'email' => $userData['email'],
        ]);

        $user = User::where('email', $userData['email'])->first();
        // Ensure the response data matches the UserResource structure for the created user
        $response->assertJson(['data' => ['id' => $user->id, 'name' => $user->name, 'email' => $user->email]]);
    }

    /**
     * Test user registration failure with validation errors.
     *
     * @return void
     */
    public function test_user_registration_fails_with_validation_errors()
    {
        // Missing name and password confirmation
        $response = $this->postJson('/api/register', ['email' => 'test@example.com', 'password' => 'password']);
        $response->assertStatus(422)->assertJsonValidationErrors(['name', 'password']);

        // Invalid email
        $response = $this->postJson('/api/register', ['name' => 'Test', 'email' => 'invalid-email', 'password' => 'password123', 'password_confirmation' => 'password123']);
        $response->assertStatus(422)->assertJsonValidationErrors(['email']);

        // Password mismatch
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => $this->faker->unique()->safeEmail, // Use unique email to avoid conflict with other tests
            'password' => 'password123',
            'password_confirmation' => 'wrongpassword',
        ]);
        $response->assertStatus(422)->assertJsonValidationErrors(['password']);

        // Email already taken
        $existingUser = User::factory()->create();
        $response = $this->postJson('/api/register', [
            'name' => 'Another User',
            'email' => $existingUser->email, // Use existing user's email
            'password' => 'password123',
            'password_confirmation' => 'password123',
        ]);
        $response->assertStatus(422)->assertJsonValidationErrors(['email']);
    }

    /**
     * Test user login with correct credentials.
     *
     * @return void
     */
    public function test_user_can_login_with_correct_credentials()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'password123',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure(['token']);
    }

    /**
     * Test user login failure with incorrect credentials.
     *
     * @return void
     */
    public function test_user_login_fails_with_incorrect_credentials()
    {
        $user = User::factory()->create([
            'password' => bcrypt('password123'),
        ]);

        // Incorrect password
        $response = $this->postJson('/api/login', [
            'email' => $user->email,
            'password' => 'wrongpassword',
        ]);
        $response->assertStatus(401);

        // Non-existent email
        $response = $this->postJson('/api/login', [
            'email' => 'nonexistent@example.com',
            'password' => 'password123',
        ]);
        $response->assertStatus(401);
    }
}
