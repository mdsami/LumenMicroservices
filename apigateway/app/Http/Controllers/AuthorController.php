<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AuthorService;

class AuthorController extends Controller
{
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
    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    /**
     *  Get all existing authors
     * 
     *  @return \Illuminate\Http\Response
     */
    public function index(): \Illuminate\Http\Response
    {
        return $this->authorService->indexAuthors();
    }

    /**
     *  Create an author
     * 
     *  @param Illuminate\Http\Request $request
     * 
     *  @return \Illuminate\Http\Response
     */
    public function store(Request $request): \Illuminate\Http\Response
    {
        return $this->authorService->storeAuthor($request->all());
    }

    /**
     *  Show an existing author
     * 
     *  @param string $author
     * 
     *  @return \Illuminate\Http\Response
     */
    public function show(string $author): \Illuminate\Http\Response
    {
        return $this->authorService->showAuthor($author);
    }

    /**
     *  Update an existing author
     * 
     *  @param Illuminate\Http\Request $request
     *  @param string $author
     * 
     *  @return \Illuminate\Http\Response
     */
    public function update(Request $request, string $author): \Illuminate\Http\Response
    {
        return $this->authorService->updateAuthor($request->all(), $author);    
    }

    /**
     *  Delete an existing author
     * 
     *  @param string $author
     * 
     *  @return \Illuminate\Http\Response
     */
    public function destroy(string $author): \Illuminate\Http\Response
    {
        return $this->authorService->destroyAuthor($author);
    }
}
