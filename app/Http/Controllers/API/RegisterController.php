<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use App\Models\User; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $users = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        

        if ($users) {
            
            $token = $users->createToken('api_token')->plainTextToken;

            return response()->json([
                'message' => 'Registration successful',
                'token_type' => 'Bearer',
                'token' => $token,
                'users' => $users,
            ], 201);
        } else {
            return response()->json([
                'message' => 'Something went wrong during registration',
            ], 500);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        if ($request->user()) { 
            $request->user()->currentAccessToken()->delete(); 

            return response()->json([
                'message' => 'Logged out successfully',
            ], 200);
        } else {
            return response()->json([
                'message' => 'Not Authenticated',
            ], 401); 
        }
    }

    public function profile(Request $request): JsonResponse
    {
        if ($request->user()) { 
            return response()->json([
                'message' => 'Profile fetched.',
                'data' => $request->user() 
            ], 200);
        } else {
            return response()->json([
                'message' => 'Not Authenticated',
            ], 401); 
        }
    }
}
