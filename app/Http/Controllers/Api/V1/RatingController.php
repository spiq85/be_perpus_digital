<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;

class RatingController extends Controller
{
    // Menyimpan Rating di Storage
    public function store(Request $request, Book $book)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $rating = $book->ratings()->updateOrCreate(
            [
                'id_user' => Auth::id(),
            ],
            [
                'rating' => $requets->rating,
            ]
        );
        return response()->json([
            'message' => 'Rating Successfully Submitted.',
            'rating' => $rating,
        ], 201);
    }
}
