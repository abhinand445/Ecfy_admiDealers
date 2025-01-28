<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    
    public function index()
    {
        // Fake data
        $categories = [
            ['id' => 1, 'name' => 'Electronics', 'description' => 'Electronic gadgets'],
            ['id' => 2, 'name' => 'Books', 'description' => 'Various books and literature'],
        ];

        return response()->json(['categories' => $categories]);
    }

    public function store(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:500',
        ]);

        
        $newCategory = [
            'id' => rand(3, 100), 
            'name' => $request->name,
            'description' => $request->description,
        ];

        return response()->json(['message' => 'Category created successfully', 'category' => $newCategory], 201);
    }
}
