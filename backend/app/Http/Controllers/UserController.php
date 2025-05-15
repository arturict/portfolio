<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    //
    public function index()
    {
        $users = User::all();
        return response()->json($users);
    }
    public function store(Request $request)
    {
        $user = User::create($request->all());
        return response()->json($user);
    }
    public function update(User $user, Request $request)
    {
        $user->update($request->all());
        return response()->json($user);
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
