<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Dealers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class DealersController extends Controller
{
   
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
                $token = $user->createToken('UserToken')->plainTextToken;
                $roleMessage = 'Logged in successfully as User';
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

    
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'module_id' => 'required|exists:modules,id',
            'zone_id' => 'required|exists:zones,id',
            'latitude_store' => 'required|numeric',
            'longitude_store' => 'required|numeric',
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:dealers,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed.',
                'data' => ['errors' => $validator->errors()]
            ], 422);
        }

    
        $logoPath = $request->hasFile('logo') 
            ? $request->file('logo')->store('dealer_logos', 'public') 
            : null;

        
        $dealer = Dealers::create([
            'store_name' => $request->store_name,
            'address' => $request->address,
            'logo' => $logoPath,
            'module_id' => $request->module_id,
            'zone_id' => $request->zone_id,
            'latitude_store' => $request->latitude_store,
            'longitude_store' => $request->longitude_store,
            'f_name' => $request->f_name,
            'l_name' => $request->l_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

       
        $user = User::create([
            'name' => $request->f_name . ' ' . $request->l_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'admin' 
        ]);

        $token = $user->createToken('DealerToken')->plainTextToken;

        return response()->json([
            'status' => 'success',
            'message' => 'Dealer created successfully and added to the users table.',
            'data' => [
                'token' => $token,
                'dealer' => [
                    'id' => $dealer->id,
                    'store_name' => $dealer->store_name,
                    'email' => $dealer->email,
                    'phone' => $dealer->phone
                ]
            ]
        ], 201);
    }
}
