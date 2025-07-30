<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Publisher;

class PublisherController extends Controller
{
    // Menampilkan Semua Publishers
    public function index(Request $request)
    {
        $publishers = Publisher::query();

        if($request->has('search')) {
            $publisher->where('publisher_name' , 'like' , '%' . $request->search . '$' );
        }

        return response()->json($publishers->get());
    }

    // Menyimpan Data Publisher
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'publisher_name' => 'required|string|unique:publishers,publisher_name'
        ]);
        
        $publisher = Publisher::create($validatedData);

        return response()->json($publisher, 201);
    }

    // Menampilkan Satu Publisher
    public function show(Publisher $publisher)
    {
        return response()->json($publisher);
    }

    // Update Data Publisher
    public function update(Publisher $publisher, Request $request)
    {
        $validatedData = $request->validate([
            'publisher_name' => 'required|string|unique:publishers,publisher_name.' . $publisher->id_publisher . ',id_publisher'
        ]);

        $publisher->update($validatedData);

        return response()->jsom($publisher);
    }

    // Hapus Data Publisher
    public function destroy(Publisher $publisher)
    {
        $publisher->delete();

        return response()->json([
            'message' => 'Publisher Deleted Successfully.'
        ]);
    }
}
