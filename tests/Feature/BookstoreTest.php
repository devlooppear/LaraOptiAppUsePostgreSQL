<?php

namespace Tests\Feature;

use App\Models\Book;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Passport\Passport;
use Tests\TestCase;

class BookstoreTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test creating a new book.
     *
     * @test
     */
    public function storeBook(): void
    {
        // Create a user using the factory
        $user = User::factory()->create();

        // Act as the created user
        Passport::actingAs($user);

        // Create a book using the factory
        $book = Book::factory()->create();

        // Define book data for the API request
        $bookData = [
            'title' => 'Sample Book',
            'author' => 'Sample Author',
            'category' => 'Sample Category',
            'isbn' => '9781234567890',
            'availability' => 1,
        ];

        // Send a request to create a new book
        $response = $this->post('/api/books', $bookData);

        // Assert that the request was successful
        $response->assertSuccessful();

        // Assert that the response JSON matches the expected data
        $response->assertJson([
            'title' => $bookData['title'],
            'author' => $bookData['author'],
            'category' => $bookData['category'],
            'isbn' => $bookData['isbn'],
            'availability' => $bookData['availability'],
        ]);

        // Assert that the book is present in the database
        $this->assertDatabaseHas('books', [
            'title' => $bookData['title'],
            'isbn' => $bookData['isbn'],
        ]);
    }

    /**
     * Test creating a new book with invalid data.
     *
     * @test
     */
    public function storeBookWithInvalidData(): void
    {
        // Create a user using the factory
        $user = User::factory()->create();

        // Act as the created user
        Passport::actingAs($user);

        // Define invalid book data for the API request
        $invalidBookData = [
            'title' => 437856739,
            'author' => true,
            'category' => 5.7,
            'isbn' => 476325876,
        ];

        // Send a request to create a new book with invalid data
        $response = $this->post('/api/books', $invalidBookData);

        // Assert that the request returns a 422 status code for validation error
        $response->assertStatus(422);
    }
}
