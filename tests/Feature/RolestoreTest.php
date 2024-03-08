<?php

namespace Tests\Feature;

use App\Models\Role;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class RoleStoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test for storing a role.
     *
     * @test
     */
    public function storeRole(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $role = Role::factory()->create();

        $roleData = [
            'id' => $role->id + 1,
            'name' => 'Example Role',
        ];

        $response = $this->post('/api/roles', $roleData);

        $response->assertSuccessful();

        $response->assertJson([
            'id' => $roleData['id'],
            'name' => $roleData['name'],
        ]);
    }
}
