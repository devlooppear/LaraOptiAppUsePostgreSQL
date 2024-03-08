<?php

namespace Tests\Feature;

use App\Models\Permission;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class PermissionIndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test retrieving a list of permissions.
     *
     * @test
     */
    public function indexPermissions(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        Permission::factory()->count(3)->create();

        $response = $this->get('/api/permissions');

        $response->assertStatus(200);

        $data = $response->json();

        $this->assertCount(3, $data);

        $response->assertJsonStructure([
            '*' => [
                'id',
                'name',
            ],
        ]);
    }
}
