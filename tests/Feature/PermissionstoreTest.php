<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PermissionStoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test creating a new permission.
     *
     * @test
     */
    public function createPermission(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $newPermissionData = [
            'name' => 'New Permission',
        ];

        $response = $this->post('/api/permissions', $newPermissionData);

        $response->assertStatus(201);

        $response->assertJsonStructure([
            'id',
            'name',
        ]);

        $response->assertJson([
            'name' => $newPermissionData['name'],
        ]);

        $this->assertDatabaseHas('permissions', [
            'name' => $newPermissionData['name'],
        ]);
    }
}
