<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class RoleIndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test for fetching the list of roles.
     *
     * @test
     */
    public function indexRoles(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $response = $this->get('/api/roles');

        $response->assertOk();
    }
}
