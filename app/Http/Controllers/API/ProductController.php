<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Retrieve all products.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $products = Product::all();

        return response()->json([
            'message' => 'Products retrieved successfully',
            'data' => $products,
        ], 200);
    }

    /**
     * Store a new product with image upload.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'qty_type' => 'required|string|max:50',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|integer|exists:categories,id',
            'sub_category' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('assets/img', 'public');
            $validated['image'] = $imagePath; 
        }

        $product = Product::create($validated);

        return response()->json([
            'message' => 'Product created successfully',
            'data' => $product,
        ], 201);
    }


    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found',
            ], 404);
        }

        return response()->json([
            'message' => 'Product retrieved successfully',
            'data' => $product,
        ], 200);
    }


   public function update(Request $request, $id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|integer|min:0',
            'qty_type' => 'required|string|max:50',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|integer|exists:categories,id',
            'sub_category' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('assets/img', 'public');
            $validated['image'] = $imagePath;
        }

        $product->update($validated);

        return response()->json([
            'message' => 'Product updated successfully',
            'data' => $product,
        ], 200);
    }

    public function destroy($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'message' => 'Product not found',
            ], 404);
        }

        $product->delete();

        return response()->json([
            'message' => 'Product deleted successfully',
        ], 200);
    }
}
