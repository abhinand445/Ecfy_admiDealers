<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use App\Models\AdminUser;

class LoginController extends Controller
{
   public function login(Request $request): \Illuminate\Http\JsonResponse
{
    
    \Log::info('Login Request Data:', $request->only('email', 'password'));

    
    $request->validate([
        'email' => 'required|email',
        'password' => 'required|string|min:6',
    ]);

    
    if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
        $users = Auth::user();
        $token = $users->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'Login successful',
            'token_type' => 'Bearer',
            'token' => $token,
            'users' => $users,
        ], 200);
    }

    
    return response()->json([
        'message' => 'Invalid credentials',
    ], 401);
}

}
