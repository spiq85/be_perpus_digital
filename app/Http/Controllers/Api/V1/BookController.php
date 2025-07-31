<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\ReadingHistory;

class BookController extends Controller
{
    // Menampilkan List Buku
    public function index()
    {
        $books = Book::with(['author' , 'category'])->latest()->paginate(10);
        return response()->json($books);
    }

    // Menampilkan Detail Buku
    public function show(Book $book)
    {
        $book->load(['author' , 'category' , 'publisher']);
        return response()->json($book);
    }

    public function read(Book $book)
    {

        ReadingHistory::create([
            'id_user' => Auth::id(),
            'id_book' => $book->id_book,
            'read_at' => now()
        ]);

        $ebook = $book->getFirstMedia('ebooks');

        if (!$ebook) {
            return response()->json(['message' => 'E-book file not found'], 404);
        }
        return $ebook;
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'slug' => 'required|string|unique:books,slug',
            'description' => 'required|string',
            'id_category' => 'required|exists:categories,id_category',
            'id_author' => 'required|exists:authors,id_author',
            'id_publisher' => 'required|exists:publishers,id_publisher',
            'publication_year' => 'required|digits:4',
            'cover_image' => 'required|image|mimes:jpg,jpeg,png|max:2048',
            'ebook_file' => 'required|file|mimes:pdf,epub',
        ]);

        $book = Book::create($request->except('ebook_file', 'cover_image'));

        if($request->hasFile('cover_image')) {
            $book->addMediaFromRequest('cover_image')->toMediaCollection('covers');
        }

        if($request->hasFile('ebook_file')) {
            $book->addNediaFromRequest('ebook_file')->toMediaCollection('ebooks');
        }
        $book->load(['author' , 'category' , 'publisher']);
        return response()->json(['message' => 'Book Created Successfully.' , 'book' => $book], 201);
    }
}
