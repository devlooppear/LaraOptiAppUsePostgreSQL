<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PermissionDestroyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test destroying a permission.
     *
     * @test
     */
    public function destroyPermission(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $permission = Permission::factory()->create();

        $response = $this->delete("/api/permissions/{$permission->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('permissions', ['id' => $permission->id]);
    }

    /**
     * Test destroying a nonexistent permission.
     *
     * @test
     */
    public function destroyNonexistentPermission(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $nonexistentPermissionId = 382764265463478;

        $response = $this->delete("/api/permissions/{$nonexistentPermissionId}");

        $response->assertStatus(404);
    }
}
