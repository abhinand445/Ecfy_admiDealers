<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PurchasingController extends Controller
{
    
    public function store(Request $request)
    {
        
        $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
        ]);

        
        $newPurchase = [
            'id' => rand(1, 1000), 
            'product_id' => $request->product_id,
            'quantity' => $request->quantity,
            'total_price' => $request->total_price,
        ];

        
        return response()->json(['message' => 'Purchase recorded successfully', 'data' => $newPurchase], 201);
    }
}
