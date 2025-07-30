<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function toggle(Book $book)
    {
        $user = Auth::user();

        $user->favoriteBooks()->toggle($book->id_book);

        return response()->json(['message' => 'Favorite Status Updated Successfully']);
    }

    public function index()
    {
        $favoriteBooks = Auth::user()->favoriteBooks()->with('author')->paginate(10);
        return response()->json($favoriteBooks);
    }
}
