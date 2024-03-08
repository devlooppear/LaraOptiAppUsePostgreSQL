<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class BookShowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function showBookById(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $book = Book::factory()->create();

        $response = $this->get("/api/books/{$book->id}");

        $response->assertStatus(200);

        $response->assertJson([
            'id' => $book->id,
            'title' => $book->title,
        ]);
    }

    /**
     * Test retrieving a book that does not exist.
     *
     * @test
     */
    public function showNonexistentBook(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $nonexistentBookId = 382764265463478;

        $response = $this->get("/api/books/{$nonexistentBookId}");

        $response->assertStatus(404);
    }
}
