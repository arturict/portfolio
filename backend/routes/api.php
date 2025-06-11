<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\UserController;

// Public routes with rate limiting
Route::middleware(['throttle:10,1'])->group(function () {
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/register', [UserController::class, 'store']);
});

// Public projects (for portfolio display) - more lenient rate limiting
Route::middleware(['throttle:60,1'])->group(function () {
    Route::get('/projects', [ProjectController::class, 'index']);
    Route::get('/projects/{project}', [ProjectController::class, 'show']);
});

// Protected routes with authentication and rate limiting
Route::middleware(['auth:sanctum', 'throttle:120,1'])->group(function () {
    // User routes
    Route::get('/user', [UserController::class, 'user']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::put('/user', [UserController::class, 'update']);
    
    // User's projects management
    Route::get('/user/projects', [ProjectController::class, 'userProjects']);
    Route::post('/projects', [ProjectController::class, 'store']);
    Route::put('/projects/{project}', [ProjectController::class, 'update']);
    Route::delete('/projects/{project}', [ProjectController::class, 'delete']);
});