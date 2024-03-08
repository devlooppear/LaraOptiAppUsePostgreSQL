<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PermissionUpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test updating an existing permission.
     *
     * @test
     */
    public function updatePermission(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $permission = Permission::factory()->create();

        $updatedPermissionData = [
            'name' => 'Updated Permission Name',
        ];

        $response = $this->post("/api/permissions/{$permission->id}", $updatedPermissionData);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'id',
            'name',
        ]);

        $response->assertJson([
            'name' => $updatedPermissionData['name'],
        ]);

        $this->assertDatabaseHas('permissions', [
            'id' => $permission->id,
            'name' => $updatedPermissionData['name'],
        ]);
    }
}
