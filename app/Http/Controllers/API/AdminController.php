<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class AdminController extends Controller
{
    // Login API
    public function login(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => 'Validation failed.', 'messages' => $validator->errors()], 422);
        }

      
        $user = User::where('email', $request->email)->first();

        
        if (!$user) {
            return response()->json(['error' => 'No user found with that email.'], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json(['error' => 'Invalid credentials.'], 401);
        }

        
        $token = null;
        $roleMessage = '';

        if ($user->role === 'superAdmin') {
            $token = $user->createToken('SuperAdminToken')->plainTextToken;
            $roleMessage = 'Logged in successfully as SuperAdmin';
        } elseif ($user->role === 'admin') {
            $token = $user->createToken('AdminToken')->plainTextToken;
            $roleMessage = 'Logged in successfully as Admin';
        } elseif ($user->role === 'seller') {
            $token = $user->createToken('DealerToken')->plainTextToken;
            $roleMessage = 'Logged in successfully as Dealer';
        } else {
            return response()->json(['error' => 'Unauthorized role.'], 403);
        }

        return response()->json([
            'token' => $token,
            'message' => $roleMessage,
            'user' => $user,
        ], 200);
    }

    // Logout API

    public function logout(Request $request)
    {
        
        if (Auth::check()) {
            Auth::user()->tokens->each(function ($token) {
                $token->delete();
            });
        }

        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out successfully.'], 200);
    }
}
