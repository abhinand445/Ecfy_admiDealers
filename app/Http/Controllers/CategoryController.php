<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Retrieve all categories.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $categories = Category::all();

        return response()->json([
            'message' => 'Categories retrieved successfully',
            'data' => $categories,
        ], 200);
    }

    /**
     * Store a new category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'position' => 'nullable|integer',
            'status' => 'required|in:active,inactive',
            'priority' => 'nullable|integer',
            'module_id' => 'required|exists:modules,id', // Assuming you have a 'modules' table
            'slug' => 'required|string|unique:categories,slug',
            'featured' => 'nullable|boolean',
        ]);

        $category = Category::create($validated);

        return response()->json([
            'message' => 'Category created successfully',
            'data' => $category,
        ], 201);
    }

    /**
     * Show a specific category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Category retrieved successfully',
            'data' => $category,
        ], 200);
    }

    /**
     * Update an existing category.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $category = Categor::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found',
            ], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'nullable|string|max:255',
            'parent_id' => 'nullable|exists:categories,id',
            'position' => 'nullable|integer',
            'status' => 'required|in:active,inactive',
            'priority' => 'nullable|integer',
            'module_id' => 'required|exists:modules,id',
            'slug' => 'required|string|unique:categories,slug,' . $id,
            'featured' => 'nullable|boolean',
        ]);

        $category->update($validated);

        return response()->json([
            'message' => 'Category updated successfully',
            'data' => $category,
        ], 200);
    }

    /**
     * Delete a category.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        $category = Category::find($id);

        if (!$category) {
            return response()->json([
                'message' => 'Category not found',
            ], 404);
        }

        $category->delete();

        return response()->json([
            'message' => 'Category deleted successfully',
        ], 200);
    }
}
