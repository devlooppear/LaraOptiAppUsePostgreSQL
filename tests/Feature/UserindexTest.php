<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class UserIndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test for fetching a list of users.
     *
     * @test
     */
    public function fetchListOfUsers(): void
    {
        User::factory()->create();

        $user = User::factory()->create();
        Passport::actingAs($user);

        $response = $this->getJson('/api/users');

        $response->assertSuccessful();
    }
}
