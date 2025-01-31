<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class ProductController extends Controller
{
    // Only admins can create a product
    public function create(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json(['message' => 'Access Denied. Only admins can create products.'], 403);
        }

        // Validation rules
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'quantity' => 'required|integer|min:1',
            'qty_type' => 'required|string|max:50',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category_id' => 'required|integer|exists:categories,id',
            'sub_category' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
        }

        $product = new Product();
        $product->name = $request->name;
        $product->image = $imagePath;
        $product->quantity = $request->quantity;
        $product->qty_type = $request->qty_type;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->sub_category = $request->sub_category;
        $product->dealer_id = Auth::user()->id; 
        $product->save();

        return response()->json([
            'message' => 'Product created successfully',
            'product' => $product
        ], 201);
    }

    public function index()
    {
        $products = Product::all();
        return response()->json($products, 200);
    }


    public function show($id)
    {
        $product = Product::find($id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json($product, 200);
    }

   public function update(Request $request, $id)
{
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        return response()->json(['message' => 'Access Denied. Only admins can update products.'], 403);
    }

    $product = Product::find($id);
    if (!$product) {
        return response()->json(['message' => 'Product not found'], 404);
    }


    $validator = Validator::make($request->all(), [
        'name' => 'sometimes|required|string|max:255',
        'image' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'quantity' => 'sometimes|required|integer|min:1',
        'qty_type' => 'sometimes|required|string|max:50',
        'description' => 'sometimes|nullable|string',
        'price' => 'sometimes|required|numeric|min:0',
        'category_id' => 'sometimes|required|integer|exists:categories,id',
        'sub_category' => 'sometimes|nullable|string|max:255',
        'dealer_id' => 'sometimes|required|integer|exists:users,id'
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    if ($request->hasFile('image')) {
        $product->image = $request->file('image')->store('product_images', 'public');
    }

    $product->update($request->only([
        'name', 'quantity', 'qty_type', 'description', 'price', 'category_id', 'sub_category', 'dealer_id'
    ]));

    return response()->json([
        'message' => 'Product updated successfully',
        'product' => $product
    ], 200);
}

}
