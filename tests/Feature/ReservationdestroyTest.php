<?php

namespace Tests\Feature;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ReservationDestroyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test deleting a reservation.
     *
     * @test
     */
    public function deleteReservation(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $reservation = Reservation::factory()->create();

        $response = $this->delete("/api/reservations/{$reservation->id}");

        $response->assertSuccessful();

    }

    /**
     * Test deleting a non-existent reservation.
     *
     * @test
     */
    public function deleteNonexistentReservation(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $nonexistentReservationId = 999999;

        $response = $this->delete("/api/reservations/{$nonexistentReservationId}");

        $response->assertStatus(404);

    }
}
