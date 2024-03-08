<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PermissionShowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test retrieving details of a specific permission.
     *
     * @test
     */
    public function showPermission(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $permission = Permission::factory()->create();

        $response = $this->get("/api/permissions/{$permission->id}");

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'id',
            'name',
        ]);

        $response->assertJson([
            'id' => $permission->id,
            'name' => $permission->name,
        ]);
    }

    /**
     * Test retrieving details of a nonexistent permission.
     *
     * @test
     */
    public function showNonexistentPermission(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $nonexistentPermissionId = 382764265463478;

        $response = $this->get("/api/permissions/{$nonexistentPermissionId}");

        $response->assertStatus(404);
    }
}
