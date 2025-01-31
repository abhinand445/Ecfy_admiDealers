<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;

class ProductController extends Controller
{
    
    public function create()
    {
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'Access Denied.');
        }
        return view('products.create'); 
    }

    
    public function store(Request $request)
    {
        
        if (Auth::user()->role !== 'admin') {
            return redirect()->route('home')->with('error', 'Access Denied.');
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

        // If validation fails
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('product_images', 'public');
        }

        // Create a new product
        $product = new Product();
        $product->name = $request->name;
        $product->image = $imagePath;
        $product->quantity = $request->quantity;
        $product->qty_type = $request->qty_type;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->category_id = $request->category_id;
        $product->sub_category = $request->sub_category;
        $product->dealer_id = Auth::user()->id; // Store dealer_id from logged-in admin
        $product->save();

        return redirect()->route('products.index')->with('success', 'Product added successfully.');
    }
}

