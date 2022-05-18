<?php

namespace App\Services;

class BookService
{
    /**
     *  Base uri to be consumed in the Book Service
     * 
     *  @var string
     */
    public string $baseUri;

    /**
     *  Secret to be consumed in the Book Service
     * 
     *  @var string
     */
    public string $secret;

    /**
     *  Service Object to use the HttpService
     * 
     *  @var HttpService $httpService
     */
    public HttpService $httpService;

    public function __construct(HttpService $httpService)
    {
        $this->baseUri = config('services.books.base_uri');
        $this->secret = config('services.books.secret');
        $this->httpService = $httpService;
    }

    /**
     *  Get all books
     * 
     *  @return \Illuminate\Http\Response
     */
    public function indexBooks(): \Illuminate\Http\Response
    {
        return $this->httpService->performRequest($this->baseUri, "books", "GET", ["Authorization" => $this->secret]);
    }

    /**
     *  Create a book
     * 
     *  @param array $request 
     * 
     *  @return \Illuminate\Http\Response
     */
    public function storeBook(array $request): \Illuminate\Http\Response
    {
        return $this->httpService->performRequest($this->baseUri, "books", "POST", ["Authorization" => $this->secret], $request);
    }

    /**
     *  Show an existing book
     * 
     *  @param string $book 
     * 
     *  @return \Illuminate\Http\Response
     */
    public function showBook(string $book): \Illuminate\Http\Response
    {
        return $this->httpService->performRequest($this->baseUri, "books/{$book}", "GET", ["Authorization" => $this->secret]);
    }

    /**
     *  Update an existing book
     * 
     *  @param array $request
     *  @param string $book 
     * 
     *  @return \Illuminate\Http\Response
     */
    public function updateBook(array $request, string $book): \Illuminate\Http\Response
    {
        return $this->httpService->performRequest($this->baseUri, "books/{$book}", "PUT", ["Authorization" => $this->secret], $request);
    }

    /**
     *  Delete an existing book
     * 
     *  @param string $book 
     * 
     *  @return \Illuminate\Http\Response
     */
    public function destroyBook(string $book): \Illuminate\Http\Response
    {
        return $this->httpService->performRequest($this->baseUri, "books/{$book}", "DELETE", ["Authorization" => $this->secret]);
    }
}
