<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class BookIndexTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test fetching books for an authenticated user.
     *
     * @test
     */
    public function fetchBooksForAuthenticatedUser(): void
    {

        $user = User::factory()->create();
        Passport::actingAs($user);

        $books = Book::factory()->count(3)->create();

        $response = $this->get('/api/books');

        $response->assertStatus(200);

        foreach ($books as $book) {
            $response->assertJsonFragment([
                'title' => $book->title,
                'author' => $book->author,
            ]);
        }
    }

    /**
     * Test fetching books for an unauthenticated user.
     *
     * @test
     */
    public function fetchBooksForUnauthenticatedUser(): void
    {

        $response = $this->get('/api/books');

        $response->assertStatus(401);
    }
}
