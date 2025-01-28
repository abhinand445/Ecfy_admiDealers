<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class OrderDealersController extends Controller
{
    public function index()
    {
        
        $orderDealers = [
            ['order_id' => 1, 'dealer_name' => 'Dealer1', 'order_status' => 'Shipped'],
            ['order_id' => 2, 'dealer_name' => 'Dealer2', 'order_status' => 'Pending'],
        ];

        return response()->json(['order_dealers' => $orderDealers]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_id' => 'required|integer',
            'dealer_name' => 'required|string|max:255',
            'order_status' => 'required|string',
        ]);

       
        $newOrderDealer = [
            'order_id' => $request->order_id,
            'dealer_name' => $request->dealer_name,
            'order_status' => $request->order_status,
        ];

        return response()->json(['message' => 'Order dealer association created successfully', 'data' => $newOrderDealer], 201);
    }
}
