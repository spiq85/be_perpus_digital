<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function getReadingHistory()
    {
        $user = Auth::user();

        $history = $user->readingHistory()->with('book.author')->limit(5)->get();

        return response()->json($history);
    }
}
