<?php

namespace Tests\Feature;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ReservationIndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test fetching a list of reservations.
     *
     * @test
     */
    public function fetchReservations(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $reservations = Reservation::factory(3)->create();

        $response = $this->get('/api/reservations');

        $response->assertStatus(200);

        $this->assertCount(count($reservations), $response->json());

        foreach ($reservations as $reservation) {
            $response->assertJsonFragment([
                'id' => $reservation->id,
            ]);
        }
    }

    /**
     * Test fetching reservations with authentication failure.
     *
     * @test
     */
    public function fetchReservationsWithoutAuthentication(): void
    {
        $response = $this->get('/api/reservations');

        $response->assertStatus(401);
    }
}
