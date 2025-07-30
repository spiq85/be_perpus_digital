<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BookController;
use App\Http\Controllers\Api\V1\RatingController;
use App\Http\Controllers\Api\V1\FavoriteController;
use App\Http\Controllers\Api\V1\CategoryController;
// ==============
// Public Routes
// ==============
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login' , [AuthController::class, 'login']);

Route::get('/books', [BookController::class, 'index']);
Route::get('/books/{book:slug}', [BookController::class, 'show']);

// ====================================
// Authenticated Routes (User & Admin)
// ====================================
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::get('/books/{book}/read', [BookController::class, 'read']);
    Route::post('/books/{book}/rate', [BookController::class, 'store']);

    Route::post('/books/{book}favorite', [FavoriteController::class, 'toggle']);
    Route::get('/my-favorites', [FavoriteController::class, 'index']);
});

// ========================
// Specific Routes (Admin)
// ========================
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function (){
    Route::post('books', [BookController::class, 'store']);

    Route::get('categories', [CategoryController::class, 'index']);
    Route::post('categories', [CategoryController::class, 'store']);
    Route::get('/categories/{category}', [CategoryController::class, 'show']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);
});
