<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function index()
    {
        
        $orders = [
            ['id' => 1, 'product_name' => 'Laptop', 'quantity' => 2, 'total_price' => 2000, 'status' => 'Completed'],
            ['id' => 2, 'product_name' => 'Phone', 'quantity' => 1, 'total_price' => 700, 'status' => 'Pending'],
        ];

        return response()->json(['orders' => $orders]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_name' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'total_price' => 'required|numeric',
        ]);

        $newOrder = [
            'id' => rand(3, 100),
            'product_name' => $request->product_name,
            'quantity' => $request->quantity,
            'total_price' => $request->total_price,
            'status' => 'Pending',
        ];

        return response()->json(['message' => 'Order placed successfully', 'data' => $newOrder], 201);
    }
}
