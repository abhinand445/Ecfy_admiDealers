<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Authcontroller extends Controller
{
    //

    //  public function register(Request $request): JsonResponse
    // {
    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|email|unique:admin_users,email',
    //         'password' => 'required|string|min:8|confirmed',
    //     ]);

    //     $adminUser = AdminUser::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //     ]);

    //     if ($adminUser) {
    //         $token = $adminUser->createToken('api_token')->plainTextToken;

    //         return response()->json([
    //             'message' => 'Registration successful',
    //             'token_type' => 'Bearer',
    //             'token' => $token,
    //             'user' => $adminUser,
    //         ], 201);
    //     } else {
    //         return response()->json([
    //             'message' => 'Something went wrong during registration',
    //         ], 500);
    //     }
    // }

   
    // public function login(Request $request): JsonResponse
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|string|min:6',
    //     ]);

    //     if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
    //         $user = Auth::user();

    //         $token = $user->createToken('authToken')->plainTextToken;

    //         return response()->json([
    //             'message' => 'Login successful',
    //             'token_type' => 'Bearer',
    //             'token' => $token,
    //             'user' => $user,
    //         ], 200);
    //     }

    //     return response()->json([
    //         'message' => 'Invalid credentials',
    //     ], 401);
    // }

  
    // public function logout(Request $request): JsonResponse
    // {
    //     if ($request->user()) {
    //         $request->user()->currentAccessToken()->delete();

    //         return response()->json([
    //             'message' => 'Logged out successfully',
    //         ], 200);
    //     }

    //     return response()->json([
    //         'message' => 'Not Authenticated',
    //     ], 401);
    // }

    
    // public function profile(Request $request): JsonResponse
    // {
    //     if ($request->user()) {
    //         return response()->json([
    //             'message' => 'Profile fetched successfully',
    //             'data' => $request->user(),
    //         ], 200);
    //     }

    //     return response()->json([
    //         'message' => 'Not Authenticated',
    //     ], 401);
    // }
}
