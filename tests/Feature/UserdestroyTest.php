<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserdestroyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test deleting an existing user.
     *
     * @test
     */
    public function destroyUser(): void
    {

        $user = User::factory()->create();

        $response = $this->actingAs($user, 'api')
            ->json('DELETE', "/api/users/{$user->id}");

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'User deleted successfully',
            ]);
    }
}
