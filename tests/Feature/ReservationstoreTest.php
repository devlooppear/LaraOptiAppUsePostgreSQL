<?php

namespace Tests\Feature;

use App\Models\Reservation;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class ReservationStoreTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $user = User::factory()->create([
            'name' => 'MeTestedHere',
            'email' => 'testing@example.com',
        ]);

        Passport::actingAs($user);
    }

    /**
     * Test storing a new reservation with authentication.
     *
     * @test
     */
    public function storeReservationWithAuthentication(): void
    {
        $reservation = Reservation::factory()->create();

        $user = $reservation->user;
        $book = $reservation->book;

        Passport::actingAs($user);

        $requestData = [
            'user_id' => $user->id,
            'book_id' => $book->id,
            'reservation_date' => '2024-01-26T23:54:04',
            'pickup_deadline' => '2024-02-02T23:54:04',
            'is_active' => 1,
        ];

        $response = $this->post('/api/reservations', $requestData);

        $response->assertSuccessful()
            ->assertJsonStructure([
                'data' => [
                    'user_id',
                    'book_id',
                    'reservation_date',
                    'pickup_deadline',
                    'is_active',
                    'created_at',
                    'updated_at',
                ],
            ])
            ->assertJson([
                'data' => [
                    'user_id' => $user->id,
                    'book_id' => $book->id,
                    'reservation_date' => '2024-01-26T23:54:04',
                    'pickup_deadline' => '2024-02-02T23:54:04',
                    'is_active' => 1,
                ],
            ]);
    }
}
