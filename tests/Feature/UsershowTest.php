<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UsershowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test for fetching the details of a specific user.
     *
     * @test
     */
    public function fetchUserDetails(): void
    {
        $user = User::factory()->create();

        Passport::actingAs($user);

        $response = $this->getJson("/api/users/{$user->id}");

        $response->assertStatus(200)
            ->assertJson([
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role_id' => $user->role_id,
            ]);
    }

    /**
     * Test fetching details for a nonexistent user.
     *
     * @test
     */
    public function fetchNonexistentUser(): void
    {
        $nonexistentUserId = 999;

        Passport::actingAs(User::factory()->create());

        $response = $this->getJson("/api/users/{$nonexistentUserId}");

        $response->assertStatus(404);
    }
}
