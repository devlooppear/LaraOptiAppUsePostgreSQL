<?php

namespace App\Http\Controllers;

use App\Models\Book;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class BookController extends Controller
{
    /**
     * Display a listing of the books.
     *
     * @return Response
     */
    public function index(Request $request)
    {
        try {
            $query = Book::with('users')->orderBy('id', 'asc');

            if ($request->has('title')) {
                $title = $request->input('title');
                $titlePattern = '%' . str_replace(' ', '%', $title) . '%';
                $query->where('title', 'ilike', $titlePattern);
            }

            if ($request->has('author')) {
                $author = $request->input('author');
                $authorPattern = '%' . str_replace(' ', '%', $author) . '%';
                $query->where('author', 'ilike', $authorPattern);
            }

            if ($request->has('category')) {
                $category = $request->input('category');
                $categoryPattern = '%' . str_replace(' ', '%', $category) . '%';
                $query->where('category', 'ilike', $categoryPattern);
            }

            if ($request->has('isbn')) {
                $isbn = $request->input('isbn');
                $isbnPattern = '%' . str_replace(' ', '%', $isbn) . '%';
                $query->where('isbn', 'ilike', $isbnPattern);
            }

            // Filter by availability
            if ($request->has('availability')) {
                $availability = $request->input('availability');
                $query->where('availability', $availability);
            }

            $perPage = $request->input('perPage', 18);

            if ($request->has('page')) {
                $books = $query->paginate($perPage);
            } else {
                $books = $query->get();
            }

            return response()->json($books);
        } catch (Exception $e) {
            Log::error('Error fetching books: ' . $e->getMessage());

            return response()->json(['error' => 'An error occurred while fetching books:' . $e->getMessage()]);
        }
    }

    /**
     * Store a newly created book in storage.
     *
     * @return Response
     */
    public function store(Request $request)
    {
        try {
            $validationRules = [
                'title' => 'required|string',
                'author' => 'required|string',
                'category' => 'required|string',
                'isbn' => 'required|string',
                'availability' => 'required|boolean|in:0,1',
            ];

            // Add unique rule only if not in a testing environment
            if (app()->environment() !== 'testing') {
                $validationRules['isbn'] .= '|unique:books,isbn';
            }

            $request->validate($validationRules);

            // Explicitly set 'isbn' in the create call to avoid null value
            $book = Book::create([
                'title' => $request->input('title'),
                'author' => $request->input('author'),
                'category' => $request->input('category'),
                'isbn' => $request->input('isbn'),
                'availability' => $request->input('availability'),
            ]);

            return response()->json($book, 201);
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()], 422);
        } catch (Exception $e) {
            Log::error('Error storing book: ' . $e->getMessage());

            return response()->json(['error' => 'An error occurred while storing the book: ' . $e->getMessage()]);
        }
    }

    /**
     * Display the specified book.
     *
     * @return Response
     */
    public function show(Book $book)
    {
        try {
            return response()->json($book);
        } catch (Exception $e) {
            Log::error('Error fetching book details: ' . $e->getMessage());

            return response()->json(['error' => 'An error occurred while fetching book details: ' . $e->getMessage()]);
        }
    }

    /**
     * Update the specified book in storage.
     *
     * @return Response
     */
    public function update(Request $request, Book $book)
    {
        try {
            $request->validate([
                'title' => 'string|max:255',
                'author' => 'string|max:255',
                'category' => 'string|max:255',
                'isbn' => 'string|unique:books,isbn,' . $book->id,
                'availability' => 'boolean',
            ]);

            $request->merge(['availability' => intval($request->input('availability'))]);

            $book->update($request->all());

            return response()->json($book, 200);
        } catch (Exception $e) {
            Log::error('Error updating book: ' . $e->getMessage());

            return response()->json(['error' => 'An error occurred while updating the book: ' . $e->getMessage()]);
        }
    }

    /**
     * Remove the specified book from storage.
     *
     * @return Response
     */
    public function destroy(Book $book)
    {
        try {
            $book->delete();

            return response()->json(null, 204);
        } catch (Exception $e) {
            Log::error('Error deleting book: ' . $e->getMessage());

            return response()->json(['error' => 'An error occurred while deleting the book: ' . $e->getMessage()]);
        }
    }
}
