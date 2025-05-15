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
    

}
