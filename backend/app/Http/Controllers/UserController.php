<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource; // Import UserResource

class UserController extends Controller
{
    //
    public function index()
    {
        $users = User::all();
        return UserResource::collection($users); // Use UserResource
    }
    public function store(RegisterUserRequest $request)
    {
        $user = User::create($request->validated());
        return UserResource::make($user); // Use UserResource
    }
    public function update(User $user, UpdateUserRequest $request)
    {
        $this->authorize('update', $user);
        $user->update($request->validated());
        return UserResource::make($user); // Use UserResource
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('auth_token')->plainTextToken;
            //only return the token
            return response()->json(['token' => $token]);
        } else {
            return response()->json(['error' => 'Unauthorized'], 401);
        }
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'Logged out successfully']);
    }
    

}
