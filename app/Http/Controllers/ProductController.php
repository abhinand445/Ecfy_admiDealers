<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WeightClassController extends Controller
{
    public function index()
    {
        // Fetch all weight classes
        return response()->json(['weight_classes' => []]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Logic to save weight class to the database
        return response()->json(['message' => 'Weight class created successfully'], 201);
    }
}

