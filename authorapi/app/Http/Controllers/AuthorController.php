<?php

namespace App\Http\Controllers;

use App\Author;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\AuthorResource;
use App\Http\Resources\AuthorCollection;

class AuthorController extends Controller
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
     * Return the list of authors
     * 
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        $authors = Author::all();
        return AuthorCollection::collection($authors);
    }

    /**
     * Create an author
     * 
     * @param Illuminate\Http\Request $request
     * @param App\Http\Author $author
     * 
     * @return App\Http\Resources\AuthorResource
     */
    public function store(Request $request, Author $author): AuthorResource
    {
        $this->validate($request, [
            'name' => 'required|string|max:255|unique:authors',
            'gender' => 'required|string|in:male,female',
            'country' => 'required|string|max:255'
        ]);

        $author = $author->create($request->all());
        return new AuthorResource($author);
    }

    /**
     * Show an existing author
     * 
     * @param string $author
     * 
     * @return App\Http\Resources\AuthorResource
     */
    public function show(string $author): AuthorResource
    {
        $author = Author::findOrFail($author);
        return new AuthorResource($author); 
    }

    /**
     * Update an existing author
     * 
     * @param Illuminate\Http\Request $request
     * @param string $author
     * 
     * @return App\Http\Resources\AuthorResource
     */
    public function update(Request $request, string $author): AuthorResource
    {
        $author = Author::findOrFail($author);

        $this->validate($request, [
            'name' => [
                'sometimes', 'required', 'string', 'max:255', Rule::unique('authors')->ignore($author)
            ],
            'gender' => 'sometimes|required|string|in:male,female',
            'country' => 'sometimes|required|string|max:255'
        ]);

        if($request->has('name')) {
            $author->name = $request->name;
        }

        if($request->has('gender')) {
            $author->gender = $request->gender;
        }

        if($request->has('country')) {
            $author->country = $request->country;
        }

        $author->save();
        return new AuthorResource($author);
    }

    /**
     * Delete an existing authors
     * 
     * @param string $author
     * 
     * @return App\Http\Resources\AuthorResource
     */
    public function destroy(string $author): AuthorResource
    {
        $author = Author::findOrFail($author);
        
        $author->delete();
        return new AuthorResource($author);
    }
}