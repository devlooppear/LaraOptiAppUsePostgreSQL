<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class BookDestroyTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test destroying a book for an authenticated user.
     *
     * @test
     */
    public function destroyBookForAuthenticatedUser(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $book = Book::factory()->create();

        $this->assertDatabaseHas('books', ['id' => $book->id]);

        $response = $this->delete("/api/books/{$book->id}");

        $response->assertStatus(204);

        $this->assertDatabaseMissing('books', ['id' => $book->id]);
    }

    /**
     * Test destroying a book for an unauthenticated user.
     *
     * @test
     */
    public function destroyBookForUnauthenticatedUser(): void
    {

        $book = Book::factory()->create();

        $initialBookCount = Book::count();

        $response = $this->delete("/api/books/{$book->id}");

        $response->assertStatus(401);

        $this->assertDatabaseHas('books', ['id' => $book->id]);

        $this->assertEquals($initialBookCount, Book::count());
    }
}
