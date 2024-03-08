<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class RoleUpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test for updating a role.
     *
     * @test
     */
    public function updateRole(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $role = Role::factory()->create();

        $updatedRoleData = [
            'name' => 'Updated Role Name',
        ];

        $response = $this->post("/api/roles/{$role->id}", $updatedRoleData);

        $response->assertStatus(200);

        $response->assertJson([
            'id' => $role->id,
            'name' => $updatedRoleData['name'],
        ]);
    }
}
