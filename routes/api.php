<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\BookController;
use App\Http\Controllers\Api\V1\RatingController;
use App\Http\Controllers\Api\V1\FavoriteController;
use App\Http\Controllers\Api\V1\CategoryController;
use App\Http\Controllers\Api\V1\AuthorController;
use App\Http\Controllers\Api\V1\PublisherController;
use App\Http\Controllers\Api\V1\DashboardController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\UserController;


// ==============
// Public Routes
// ==============
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login' , [AuthController::class, 'login']);

Route::get('/books', [BookController::class, 'index']);
Route::get('/books/popular', [BookController::class, 'popularBooks']);
Route::get('/books/{book:slug}', [BookController::class, 'show']);

// ====================================
// Authenticated Routes (User & Admin)
// ====================================
Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('/me', [AuthController::class, 'me']);

    Route::get('/profile', [ProfileController::class, 'show']);

    Route::get('/books/{book}/read', [BookController::class, 'read']);
    Route::post('/books/{book}/rate', [BookController::class, 'store']);

    Route::post('/books/{book}favorite', [FavoriteController::class, 'toggle']);
    Route::get('/my-favorites', [FavoriteController::class, 'index']);

    Route::get('/dashboard/history', [DashboardController::class, 'getReadingHistory']);
});

// ========================
// Specific Routes (Admin)
// ========================
Route::middleware(['auth:sanctum', 'role:admin'])->prefix('admin')->group(function (){

    Route::get('users', [UserController::class, 'index']);
    Route::get('users/{user}', [UserController::class, 'show']);
    Route::put('users/{user}', [UserController::class, 'update']);
    Route::delete('users/{user}', [UserController::class, 'destroy']);

    Route::post('books', [BookController::class, 'store']);
    Route::put('books/{book}', [BookController::class, 'update']);
    Route::delete('books/{book}', [BookController::class, 'destroy']);

    Route::get('categories', [CategoryController::class, 'index']);
    Route::post('categories', [CategoryController::class, 'store']);
    Route::get('/categories/{category}', [CategoryController::class, 'show']);
    Route::put('/categories/{category}', [CategoryController::class, 'update']);
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy']);

    Route::get('authors', [AuthorController::class, 'index']);
    Route::post('authors', [AuthorController::class, 'store']);
    Route::put('/authors/{author}', [AuthorController::class, 'update']);
    Route::delete('/authors/{author}', [AuthorController::class, 'destroy']);

    Route::get('publishers', [PublisherController::class, 'index']);
    Route::post('publishers', [PublisherController::class, 'store']);
    Route::put('/publishers/{publisher}', [PublisherController::class, 'update']);
    Route::delete('/publishers/{publisher}', [PublisherController::class, 'destroy']);

    Route::get('dashboard/highest-rated-books', [DashboardController::class, 'highestRatedBooks']);
    Route::get('dashboard/active-users', [DashboardController::class, 'activeUsers']);
});
