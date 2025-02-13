<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;
use App\Models\User;
use App\Models\Zone;

class AdminController extends Controller
{

     public function getAllZones(): JsonResponse
    {
       $zones = Zone::all();
      

        return response()->json([
            'success' => true,
            'data' => $zones
        ]);
    }


    // Login API
    
    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'data' => [
                    'errors' => $validator->errors()
                ]
            ], 422);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'No user found with that email.',
                'data' => null
            ], 404);
        }

        if (!Hash::check($request->password, $user->password)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Invalid credentials.',
                'data' => null
            ], 401);
        }

        $token = null;
        $roleMessage = '';

        switch ($user->role) {
            case 'superAdmin':
                $token = $user->createToken('SuperAdminToken')->plainTextToken;
                $roleMessage = 'Logged in successfully as SuperAdmin';
                break;
            case 'admin':
                $token = $user->createToken('AdminToken')->plainTextToken;
                $roleMessage = 'Logged in successfully as Admin';
                break;
            case 'user':
                $token = $user->createToken('DealerToken')->plainTextToken;
                $roleMessage = 'Logged in successfully as Dealer';
                break;
            default:
                return response()->json([
                    'status' => 'error',
                    'message' => 'Unauthorized role.',
                    'data' => null
                ], 403);
        }

        return response()->json([
            'status' => 'success',
            'message' => $roleMessage,
            'data' => [
                'token' => $token,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $user->role
                ]
            ]
        ], 200);
    }

    
    public function logout(Request $request)
    {
        if (Auth::check()) {
            Auth::user()->tokens()->delete(); 
        }

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'status' => 'success',
            'message' => 'Logged out successfully.',
            'data' => null
        ], 204);
    }


     public function sendResetLinkEmail(Request $request)
    {
        $request->validate(['email' => 'required|email|exists:users,email']);

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? response()->json(['message' => __($status)], 200)
            : response()->json(['message' => __($status)], 400);
    }

    // Reset Password

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'token' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? response()->json(['message' => __($status)], 200)
            : response()->json(['message' => __($status)], 400);
    }
}
