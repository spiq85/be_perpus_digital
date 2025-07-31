<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Model\User;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    // Menampilkan Daftar User
    public function index()
    {
        return response()->json(User::with('roles')->paginate(15));
    }

    // Menampilkan Detail User
    public function show(User $user)
    {
        return response()->json($user->load('roles'));
    }

    // Update Role User
    public function update(Request $request, User $user)
    {
        $request->validate([
            'role' => 'required|string|exists:roles,name'
        ]);

        $user->syncRoles($Request->role);

        return response()->json([
            'message' => 'User Updated Successfully.',
            'user' => $user->load('roles')
        ]);
    }

    // Delete User
    public function destroy(User $user)
    {
        if(auth()->user()->id_user === $user->id_user) {
            return response()->json([
                'message' => 'You Cannot Delete Your Own Account.'
            ],403);
        }
        $user->delete();

        return response()->json([
            'message' => 'User Deleted Successfully.'
        ]);
    }
}
