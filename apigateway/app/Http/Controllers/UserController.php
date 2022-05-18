<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use App\Http\Resources\UserCollection;

class UserController extends Controller
{
    public function __construct()
    {
        //
    }

    /**
     *  Get all existing Users
     *
     *  @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {

        $users = User::all();
        return UserCollection::collection($users);
    }

    /**
     *  Create a User
     *
     *  @param Illuminate\Http\Request $request
     *
     *  @return App\Http\Resources\UserResource
     */
    public function store(Request $request, User $user): UserResource
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);

        $data = $request->all();
        $data['password'] = Hash::make($request->password);

        $user = $user->create($data);
        return new UserResource($user);
    }

    /**
     *  Show an existing User
     *
     *  @param string $user
     *
     *  @return App\Http\Resources\UserResource
     */
    public function show(string $user): UserResource
    {
        $user = User::findOrFail($user);
        return new UserResource($user);
    }

    /**
     *  Update an existing user
     *
     *  @param Illuminate\Http\Request $request
     *  @param string $user
     *
     *  @return App\Http\Resources\UserResource
     */
    public function update(Request $request, string $user): UserResource
    {
        $user = User::findOrFail($user);

        $this->validate($request, [
            'name' => 'sometimes|required|string|max:255',
            'email' => [
                'sometimes', 'required', 'email', 'max:255', Rule::unique('users')->ignore($user)
            ],
            'password' => 'sometimes|required|min:6|confirmed'
        ]);

        $user->fill($request->all());   // Fill only add those variables to the Model which are passed through the request

        if ($request->has('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();
        return new UserResource($user);
    }

    /**
     *  Delete an existing User
     *
     *  @param string $user
     *
     *  @return App\Http\Resources\UserResource
     */
    public function destroy(string $user): UserResource
    {
        $user = User::findOrFail($user);

        $user->delete();
        return new UserResource($user);
    }


    /**
     *  Identify an existing User, Need to make sure that there exist a user which has this following access_token
     *
     *  @param Request $request
     *
     *  @return App\Http\Resources\UserResource
     */
    public function me(Request $request): UserResource
    {
        // ? Obtain the current User which has send the request
        return new UserResource($request->user());
    }
}
