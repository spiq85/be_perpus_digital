<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Author;

class AuthorController extends Controller
{
    // Menampilkan Semua Authors
    public function index(Request $request)
    {
        $authors = Author::query();

        if($request->has('search'))
        {
            $authors->where('author_name' , 'like' , '%' . $request->search . '%');
        }
        
        return response()->json($authors->get());
    }

    // Menyimpan Author Baru
    public function store(Request $request){
        $validatedData = $request->validate([
            'author_name' => 'required|String|unique:authors,author_name'
        ]);

        $authors = Author::create($validatedData);

        return response()->json($authors, 201);
    }

    // Menampilkan Satu Author
    public function show(Author $author)
    {
        return response()->json($author);
    }

    // Update Data Author
    public function update(Author $author, Request $request)
    {
        $validatedData = $request->validate([
            'author_name' => 'required|string|unique:authors,author_name' . $author->id_author . 'id_author'
        ]);

        $author->update($validatedData);

        return response()->json($author);
    }

    // Hapus Data Author
    public function destroy(Author $author)
    {
        $author->delete();

        return response()->json([
            'message' => 'Author Deleted Successfully.'
        ]);
    }
}
