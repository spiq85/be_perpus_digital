<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    // Nampilin semua Data Halaman Profile User
    public function show()
    {
        $user = Auth::user();

        $favorites = $user->favoriteBooks()
        ->with(['author' , 'category'])
        ->limit(10)
        ->get();

        $history = $user->readingsHistory()
        ->with('book')
        ->latest()
        ->get();

        return response()->json([
            'user' => [
                'id_user' => $user->id_user,
                'username' => $user->username,
                'email' => $user->email,
            ],
            'favorites' => $favorites,
            'reading_history' => $history,
            'ratings' => $ratings,
        ]);
    }
}
