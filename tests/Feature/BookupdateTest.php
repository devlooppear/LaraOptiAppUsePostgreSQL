<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class BookUpdateTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic feature test for updating a book.
     *
     * @test
     */
    public function updateBook(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $book = Book::factory()->create();

        $newData = [
            'title' => 'New Title',
            'author' => 'New Author',
            'category' => 'New Category',
            'availability' => 1,
        ];

        $response = $this->post("/api/books/{$book->id}", $newData);
        $response->assertStatus(200);

        $book->refresh();

        $this->assertEquals($newData['title'], $book->title);
        $this->assertEquals($newData['author'], $book->author);
        $this->assertEquals($newData['category'], $book->category);
        $this->assertEquals($newData['availability'], $book->availability);
    }

    /**
     * Test updating a nonexistent book.
     *
     * @test
     */
    public function updateNonexistentBook(): void
    {
        $user = User::factory()->create();
        Passport::actingAs($user);

        $nonexistentBookId = 382764265463478;

        $newData = [
            'title' => 'New Title',
            'author' => 'New Author',
            'category' => 'New Category',
            'availability' => 1,
        ];

        $response = $this->post("/api/books/{$nonexistentBookId}", $newData);

        $response->assertStatus(404);
    }
}
