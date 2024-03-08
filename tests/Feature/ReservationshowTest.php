<?php

namespace Tests\Feature;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ReservationShowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test showing a specific reservation.
     *
     * @test
     */
    public function showReservation(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $reservation = Reservation::factory()->create();

        $response = $this->get("/api/reservations/{$reservation->id}");

        $response->assertStatus(200);

        $response->assertJson([
            'id' => $reservation->id,
            'user_id' => $reservation->user_id,
        ]);

    }

    /**
     * Test showing a nonexistent reservation.
     *
     * @test
     */
    public function showNonexistentReservation(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $nonexistentReservationId = 382764265463478;
        $response = $this->get("/api/reservations/{$nonexistentReservationId}");

        $response->assertStatus(404);

    }

    /**
     * Test showing a reservation without authentication.
     *
     * @test
     */
    public function showReservationWithoutAuthentication(): void
    {
        $reservation = Reservation::factory()->create();

        $response = $this->get("/api/reservations/{$reservation->id}");

        $response->assertStatus(401);

    }
}
