<?php

namespace Database\Factories;

use App\Models\Book;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Redis;

class BookFactory extends Factory
{
    protected $model = Book::class;

    public function definition(): array
    {
        $bookId = Redis::incr('book_ids');

        return [
            'id' => $bookId,
            'title' => $this->faker->sentence,
            'author' => $this->faker->name,
            'category' => $this->faker->word,
            'isbn' => $this->faker->unique()->isbn13,
            'availability' => $this->faker->randomElement([1, 0]),
        ];
    }
}
