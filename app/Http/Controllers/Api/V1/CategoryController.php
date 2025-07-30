<?php

namespace App\Http\Controllers\api\v1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json(Category::all());
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|unique:categories,category_name'
        ]);
        
        $category = Category::create([
            'category_name' => $request->category_name,
            'slug' => Str::slug($request->category_name)        
        ]);
        return response()->json($category, 201);
    }
    
    public function show(Category $category)
    {
        return response()->json($category);
    }

    public function update(Request $request, Category $category)
    {
        $request->validate([
            'category_name' => 'required|string|unique:categories,category_name'
        ]);

        $category->update([
            'category_name' => $request->category_name,
            'slug' => Str::slug($request->category_name)
        ]);

        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json([
            'message' => 'Category Deleted Successfully'
        ],200);
    }
}
