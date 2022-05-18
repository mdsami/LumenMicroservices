<?php

namespace App\Http\Controllers;

use App\Book;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\BookResource;
use App\Http\Resources\BookCollection;

class BookController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Return the list of books
     * 
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $books = Book::all();
        return BookCollection::collection($books);
    }

    /**
     * Create a book
     * 
     * @param Illuminate\Http\Request $request
     * @param App\Http\Book $book
     * 
     * @return App\Http\Resources\BookResource
     */
    public function store(Request $request, Book $book): BookResource
    {
        $this->validate($request, [
            'author_id' => 'required|integer|min:1',
            'title' => 'required|string|max:255|unique:books',
            'description' => 'required|string',
            'price' => 'required|min:1'
        ]);

        $book = $book->create($request->all());
        return new BookResource($book);
    }

    /**
     * Show an existing book
     * 
     * @param string $book
     * 
     * @return App\Http\Resources\BookResource
     */
    public function show(string $book): BookResource
    {
        $book = Book::findOrFail($book);
        return new BookResource($book);
    }

    /**
     * Update an existing book
     * 
     * @param Illuminate\Http\Request $request
     * @param string $book
     * 
     * @return App\Http\Resources\BookResource
     */
    public function update(Request $request, string $book): BookResource
    {
        $book = Book::findOrFail($book);

        $this->validate($request, [
            'author_id' => 'sometimes|required|integer|min:1',
            'title' => [
                'sometimes', 'required', 'string', 'max:255', Rule::unique('books')->ignore($book)
            ],
            'description' => 'sometimes|required|string',
            'price' => 'sometimes|required|min:1'
        ]);

        $book->fill($request->all());   // Fill only add those variables to the Model which are passed through the request

        $book->save();
        return new BookResource($book);
    }

    /**
     * Delete an existing books
     * 
     * @param string $book
     * 
     * @return App\Http\Resources\BookResource
     */
    public function destroy(string $book): BookResource
    {
        $book = Book::findOrFail($book);

        $book->delete();
        return new BookResource($book);
    }
}
