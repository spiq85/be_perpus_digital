<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Book;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function getReadingHistory()
    {
        $user = Auth::user();

        $history = $user->readingHistory()->with('book.author')->limit(5)->get();

        return response()->json($history);
    }

    public function highestRatedBooks()
    {
        $popularBooks = Book::orderBy('average_rating' , 'desc')
        ->orderBy('rating_counts', 'desc')
        ->limit(10)
        ->get();

        return response()->json($popularBooks);
    }

    public function activeUsers()
    {
        $actievUsers = DB::table('reading_histories')
        ->join('users', 'reading_histories.id_user' , '=' , 'users.id_user')
        ->select('users.username' , 'users.email' , DB::raw('count(reading_histories.id_book) as books_read_count'))
        ->groupBy('users.id_user' , 'users.username' , 'users.email')
        ->orderByDesc('books_read_count')
        ->limit(10)
        ->get();

        return response()->json($actievUsers);
    }
}
