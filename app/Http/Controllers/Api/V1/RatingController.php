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
                'rating' => $request->rating,
            ]
        );

        $newAverage = $book->ratings()->avg('rating');
        $ratingsCount = $book->ratings()->count();

        $book->update([
            'average_rating' => $newAverage,
            'rating_counts' => $ratingsCount,
        ]);

        return response()->json([
            'message' => 'Rating Successfully Submitted.',
            'rating' => $rating,
        ], 201);
    }
}
