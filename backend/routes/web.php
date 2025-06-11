<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

Route::get('/', function () {
    return view('welcome');
});

// Admin routes
Route::prefix('admin')->group(function () {
    Route::get('/login', [AdminController::class, 'login'])->name('admin.login');
    Route::post('/login', [AdminController::class, 'login']);
    Route::post('/logout', [AdminController::class, 'logout'])->name('admin.logout');
    
    Route::middleware('auth')->group(function () {
        Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::get('/projects/create', [AdminController::class, 'createProject'])->name('admin.projects.create');
        Route::post('/projects/create', [AdminController::class, 'createProject']);
        Route::get('/projects/{project}/edit', [AdminController::class, 'editProject'])->name('admin.projects.edit');
        Route::put('/projects/{project}', [AdminController::class, 'editProject'])->name('admin.projects.update');
        Route::delete('/projects/{project}', [AdminController::class, 'deleteProject'])->name('admin.projects.delete');
    });
});
