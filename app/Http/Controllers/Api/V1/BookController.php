<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Book;
use App\Models\ReadingHistory;
use Illuminate\Support\Facades\Auth;

class BookController extends Controller
{
    // Menampilkan List Buku
    public function index(Request $request)
    {
        $books = Book::query()->with(['author' , 'category']);

        if($request->has('search')) {
            $searchTerm = $request->search;
            $books->where(function($query) use ($searchTerm){
                $query->where('title' , 'like' , '%' . $searchTerm . '%' )
                ->orWhereHas('author', function($query) use ($searchTerm){
                    $query->where('author_name' , 'like' , '%' . $searchTerm . '%');
                });
            });
        }

        if($request->has('category')) {
            $books->where('id_category' , $request->id_category);
        }

        return response()->json($books->latest()->paginate(10));
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

    public function popularBooks()
    {
        $popularBooks = Book::with(['author' , 'category'])
        ->orderBy('average_rating' , 'desc')
        ->orderBy('rating_counts' , 'desc')
        ->limit(10)
        ->get();

        $popularBooks->each(function($book){
            $book->cover_url = $book->getFirstMediaUrl('covers');
        });

        return response()->json($popularBooks);
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
            $book->addMediaFromRequest('ebook_file')->toMediaCollection('ebooks');
        }
        $book->load(['author' , 'category' , 'publisher']);
        return response()->json(['message' => 'Book Created Successfully.' , 'book' => $book], 201);
    }

    public function update(Request $request, Book $book)
    {   
        $validatedData = $request->validate([
            'title' => 'string|max:255',
            'slug' => 'string|unique:books,slug,' . $book->id_book . ',id_book',
            'description' => 'string',
            'id_category' => 'exists:categories,id_category',
            'id_author' => 'exists:authors,id_author',
            'id_publisher' => 'exists:publishers,id_publisher',
            'publication_year' => 'digits:4',
            'cover_image' => 'image|mimes:jpeg,png,jpg|max:2048',
            'ebook_file' => 'file|mimes:pdf,epub',
        ]);

        $book->update($validatedData);

        if($request->hasFile('cover_image')) {
            $book->clearMediaCollection('covers');
            $book->addMediaFromRequest('cover_image')->toMediaCollection('covers');
        }

        if($request->hasFile('ebook_file')) {
            $book->clearMediaCollection('ebooks');
            $book->addMediaFromRequest('ebook_file')->toMediaCollection('ebooks');
        }

        return response()->json([
            'message' => 'Book Updated Successfully.' , 'book' => $book->load(['author' , 'category' , 'publisher'])
        ]);
    }

    public function destroy(Book $book)
    {
        $book->delete();

        return response()->json([
            'message' => 'Book Deleted Successfully'
        ]);
    }
}
