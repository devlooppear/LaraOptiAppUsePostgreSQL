<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserstoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test creating a new user.
     *
     * @test
     */
    public function createUser(): void
    {
        $role = Role::factory()->create();

        $uniqueIdentifier = uniqid(); // Generates a unique identifier based on the current timestamp

        // Generate a unique user with a unique email
        $user = User::factory()->create([
            'email' => 'test_' . $uniqueIdentifier . '@testingherewow.com',
        ]);

        // Try creating another user with the same email (should fail)
        $duplicateUser = User::factory()->make([
            'email' => $user->email,
        ]);

        $userData = [
            'name' => $duplicateUser->name,
            'email' => $duplicateUser->email,
            'password' => $duplicateUser->password,
            'role_id' => $role->id,
        ];

        $response = $this->json('POST', '/api/users', $userData);

        // Add assertions to verify the response
        $response->assertStatus(422) // Assuming 422 is the correct HTTP status code for validation failure
            ->assertJson([
                'error' => 'The given data was invalid.',
            ])
            ->assertJsonValidationErrors([
                'email' => 'The email has already been taken.',
            ]);
    }
}
