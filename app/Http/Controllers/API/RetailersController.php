<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RetailersController extends Controller
{
    public function index()
    {
        // $retailers = Retailer::all();
        $retailers = [
            ['id' => 1, 'name' => 'ABC Retailers', 'location' => 'New York'],
            ['id' => 2, 'name' => 'XYZ Retailers', 'location' => 'California'],
        ];

        return response()->json(['retailers' => $retailers]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'required|string|max:255',
        ]);

        
        $newRetailer = [
            'id' => rand(3, 100),
            'name' => $request->name,
            'location' => $request->location,
        ];

        return response()->json(['message' => 'Retailer created successfully', 'data' => $newRetailer], 201);
    }
}
