<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class RoleDestroyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test for destroying a role.
     *
     * @test
     */
    public function destroyRole(): void
    {
        // Assuming you have a user model and using Passport for authentication
        $user = User::factory()->create();
        Passport::actingAs($user);

        // Create a role with a unique name to be destroyed
        $role = Role::factory()->create(['name' => 'UniqueRoleName']);

        // Send a DELETE request to the API endpoint for role deletion
        $response = $this->delete("/api/roles/{$role->id}");

        // Assert that the response has a 204 status code (successful deletion)
        $response->assertStatus(204);

        // Assert that the role was deleted from the database
        $this->assertDatabaseMissing('roles', ['id' => $role->id]);
    }

    /**
     * Test destroying a nonexistent role.
     *
     * @test
     */
    public function destroyNonexistentRole(): void
    {
        // Assuming you have a user model and using Passport for authentication
        $user = User::factory()->create();
        Passport::actingAs($user);

        // A nonexistent role ID
        $nonexistentRoleId = 382764265463478;

        // Send a DELETE request to the API endpoint for a nonexistent role
        $response = $this->delete("/api/roles/{$nonexistentRoleId}");

        // Assert that the response has a 404 status code (role not found)
        $response->assertStatus(404);
    }
}
