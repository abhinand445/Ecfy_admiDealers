<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;


class RegisterController extends BaseController
{
     public function register(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_type' => 'required|in:SuperAdmin,Admin,Seller',
        ]);

    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return response()->json(['message' => 'User registered successfully', 'user' => $user], 201);
    }

    
   public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        \Log::info($request->all());

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();

            if ($user->hasRole('SuperAdmin')) {
                $token = $user->createToken('SuperAdminToken')->accessToken;

                return response()->json([
                    'token' => $token,
                    'message' => 'Logged in successfully as SuperAdmin',
                    'user' => $user,
                ], 200);
            }

            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }

    // Create Dealer (Admin) Method (SuperAdmin creates Dealer)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'f_name' => 'required|string|max:255',
            'l_name' => 'nullable|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|regex:/^[0-9]{10}$/|unique:dealers,phone',
            'email' => 'required|email|unique:dealers,email',
            'password' => 'required|string|min:8|confirmed',
            'module_id' => 'required|integer',
            'zone_id' => 'required|integer',
            'status' => 'required|boolean',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
            'store_name' => 'required|string|max:255',
        ]);

        $validated['password'] = Hash::make($validated['password']);
        $validated['role'] = 'dealer'; // Assigning the dealer role to the created user

        // Create the dealer (admin)
        $dealer = User::create([
            'name' => $validated['f_name'] . ' ' . $validated['l_name'],
            'email' => $validated['email'],
            'password' => $validated['password'],
            'address' => $validated['address'],
            'phone' => $validated['phone'],
            'module_id' => $validated['module_id'],
            'zone_id' => $validated['zone_id'],
            'status' => $validated['status'],
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'store_name' => $validated['store_name'],
            'role' => $validated['role'],
        ]);

        $dealer->assignRole('Admin'); // Assign the Admin role (dealer)

        return response()->json([
            'message' => 'Dealer created successfully',
            'data' => $dealer,
        ], 201);
    }
}
