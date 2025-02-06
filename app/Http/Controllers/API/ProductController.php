<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Models\Product;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum'); 
    }

    public function store(Request $request)
    {
        
        if (Auth::user()->role !== 'admin') {
            return response()->json([
                'status' => false,
                'message' => 'Access Denied',
                'data' => null
            ], 403);
        }

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
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 422);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
        }

        $product = Product::create([
            'name' => $request->name,
            'image' => $imagePath,
            'quantity' => $request->quantity,
            'qty_type' => $request->qty_type,
            'description' => $request->description,
            'price' => $request->price,
            'category_id' => $request->category_id,
            'sub_category' => $request->sub_category,
            'dealer_id' => Auth::user()->id,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Product added successfully',
            'data' => $product
        ], 201);
    }

    public function index()
    {
        $products = Product::all();
        return response()->json([
            'status' => 'success',
            'message' => 'Products fetched successfully',
            'data' => $products
        ], 200);
    }


    public function show($id)
    {
        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
                'data' => null
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Product fetched successfully',
            'data' => $product
        ], 200);
    }

    public function update(Request $request, $id)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json([
                'status' => false,
                'message' => 'Access Denied',
                'data' => null
            ], 403);
        }

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
                'data' => null
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'quantity' => 'nullable|integer|min:1',
            'qty_type' => 'nullable|string|max:50',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric|min:0',
            'category_id' => 'nullable|integer|exists:categories,id',
            'sub_category' => 'nullable|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 422);
        }

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::delete('public/' . $product->image);
            }
            $imagePath = $request->file('image')->store('product_images', 'public');
            $product->image = $imagePath;
        }

        $product->update([
            'name' => $request->name ?? $product->name,
            'quantity' => $request->quantity ?? $product->quantity,
            'qty_type' => $request->qty_type ?? $product->qty_type,
            'description' => $request->description ?? $product->description,
            'price' => $request->price ?? $product->price,
            'category_id' => $request->category_id ?? $product->category_id,
            'sub_category' => $request->sub_category ?? $product->sub_category,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Product updated successfully',
            'data' => $product
        ], 200);
    }

    public function destroy($id)
    {
        if (Auth::user()->role !== 'admin') {
            return response()->json([
                'status' => false,
                'message' => 'Access Denied',
                'data' => null
            ], 403);
        }

        $product = Product::find($id);

        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
                'data' => null
            ], 404);
        }

        if ($product->image) {
            Storage::delete('public/' . $product->image);
        }

        $product->delete();

        return response()->json([
            'status' => 'success',
            'message' => 'Product deleted successfully',
            'data' => null
        ], 200);
    }
}
