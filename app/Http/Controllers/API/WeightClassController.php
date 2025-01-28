<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WeightClassController extends Controller
{
    // Function to retrieve all weight classes
    public function index()
    {
        // Dummy data for weight classes
        $weightClasses = [
            ['id' => 1, 'name' => 'Lightweight', 'description' => 'For lightweight products'],
            ['id' => 2, 'name' => 'Heavyweight', 'description' => 'For heavyweight products'],
        ];

        return response()->json(['weight_classes' => $weightClasses]);
    }

    // Function to create a new weight class
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Create a new weight class (Dummy data, no database interaction)
        $newWeightClass = [
            'id' => rand(3, 100), // Generate a random ID for dummy data
            'name' => $request->name,
            'description' => $request->description,
        ];

        // Return a success response with the new weight class data
        return response()->json(['message' => 'Weight class created successfully', 'data' => $newWeightClass], 201);
    }
}
