<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BookService;
use App\Services\AuthorService;

class BookController extends Controller
{
    /**
     *  Service Object to consume the books_api microservice
     * 
     *  @var BookService $bookService
     */
    public BookService $BookService;

    /**
     *  Service Object to consume the authors_api microservice
     * 
     *  @var AuthorService $authorService
     */
    public AuthorService $authorService;

    /**
     *  Create a new controller instance.
     *
     *  @return void
     */
    public function __construct(BookService $bookService, AuthorService $authorService)
    {
        $this->bookService = $bookService;
        $this->authorService = $authorService;
    }

     /**
     *  Get all existing books
     * 
     *  @return \Illuminate\Http\Response
     */
    public function index(): \Illuminate\Http\Response
    {
        return $this->bookService->indexBooks();
    }

    /**
     *  Create a book
     * 
     *  @param Illuminate\Http\Request $request
     * 
     *  @return \Illuminate\Http\Response
     */
    public function store(Request $request): \Illuminate\Http\Response
    {
        // ? Store request will only be processed if the provided Author exists
        $response = $this->authorService->showAuthor($request->author_id);
    
        if($response->status() === 200) {
            return $this->bookService->storeBook($request->all());
        } else {
            return $response;
        }
    }

    /**
     *  Show an existing book
     * 
     *  @param string $book
     * 
     *  @return \Illuminate\Http\Response
     */
    public function show(string $book): \Illuminate\Http\Response
    {
        return $this->bookService->showBook($book);
    }

    /**
     *  Update an existing book
     * 
     *  @param Illuminate\Http\Request $request
     *  @param string $book
     * 
     *  @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $book): \Illuminate\Http\Response
    {
        if($request->has('author_id')) {
            // ? Store request will only be processed if the provided Author exists
            $response = $this->authorService->showAuthor($request->author_id);
        
            if($response->status() === 200) {
                return $this->bookService->updateBook($request->all(), $book);
            } else {
                return $response;
            }
        }
        
        return $this->bookService->updateBook($request->all(), $book);    
    }

    /**
     *  Delete an existing book
     * 
     *  @param string $book
     * 
     *  @return \Illuminate\Http\Response
     */
    public function destroy(string $book): \Illuminate\Http\Response
    {
        return $this->bookService->destroyBook($book);
    }
}
