<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');
Route::post('/logout', [UserController::class, 'logout'])->middleware('auth:sanctum');
Route::post('/login', [ UserController::class, 'login']);
Route::post('/register', [ UserController::class, 'store']);
Route::get('/projects', [ProjectController::class, 'index']);
Route::post('/projects', [ProjectController::class, 'store'])->middleware('auth:sanctum');
Route::get('/projects/{project}', [ProjectController::class, 'show']);
Route::put('/projects/{project}', [ProjectController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/projects/{project}', [ProjectController::class, 'delete'])->middleware('auth:sanctum');