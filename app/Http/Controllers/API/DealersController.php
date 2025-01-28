<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Dealer; // Ensure you have a Dealer model created
use Illuminate\Http\Request;

class DealersController extends Controller
{
    /**
     * Store a new dealer in the database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'f_name' => 'required|string|max:255',
            'l_name' => 'nullable|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|regex:/^[0-9]{10}$/|unique:dealers,phone',
            'email' => 'required|email|unique:dealers,email',
            'module_id' => 'required|integer',
            'zone_id' => 'required|integer',
            'status' => 'required|boolean',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        // Create and save the dealer
        $dealer = Dealer::create($validated);

        return response()->json([
            'message' => 'Dealer created successfully',
            'data' => $dealer,
        ], 201);
    }

    /**
     * Retrieve all dealers from the database.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $dealers = Dealer::all();

        return response()->json([
            'message' => 'Dealers retrieved successfully',
            'data' => $dealers,
        ], 200);
    }
}
