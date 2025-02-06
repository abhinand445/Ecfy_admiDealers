<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Stores;

class UsersController extends Controller
{
    /**
     * Create a dealer and associated store details.
     */
    public function createUsers(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized. Only admins can create dealers.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'store_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:users,email|unique:stores,email',
            'password' => 'required|string|min:6|confirmed',
            'latitude_store' => 'nullable|numeric',
            'longitude_store' => 'nullable|numeric',
            'module_id' => 'required|integer',
            'zone_id' => 'required|integer',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $logoPath = $request->hasFile('logo') ? $request->file('logo')->store('store_logos', 'public') : null;
        $hashedPassword = Hash::make($request->password);

        DB::beginTransaction();
        try {
            $store = Stores::create([
                'store_name' => $request->store_name,
                'address' => $request->address,
                'logo' => $logoPath,
                'f_name' => $request->f_name,
                'l_name' => $request->l_name,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => $hashedPassword,
                'latitude_store' => $request->latitude_store,
                'longitude_store' => $request->longitude_store,
                'module_id' => $request->module_id,
                'zone_id' => $request->zone_id,
            ]);

            $user = User::create([
                'name' => $request->f_name . ' ' . $request->l_name,
                'email' => $request->email,
                'password' => $hashedPassword,
                'role' => 'user',
            ]);

            $token = $user->createToken('DealerToken')->plainTextToken;

            DB::commit();

            return response()->json([
                'message' => 'User created successfully.',
                'token' => $token,
                'store' => $store,
                'user' => $user
            ], 201);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['error' => 'Failed to create user.', 'details' => $e->getMessage()], 500);
        }
    }

    /**
     * Dealer/Admin login function.
     */
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

    // Logout API
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


    public function updateUserstore(Request $request, $id)
{
    if (!Auth::check() || Auth::user()->role !== 'admin') {
        return response()->json(['error' => 'Unauthorized. Only admins can update stores.'], 403);
    }

    $validator = Validator::make($request->all(), [
        'store_name' => 'sometimes|required|string|max:255',
        'address' => 'sometimes|required|string|max:255',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'f_name' => 'sometimes|required|string|max:255',
        'l_name' => 'sometimes|required|string|max:255',
        'phone' => 'sometimes|required|string|max:15',
        'email' => 'sometimes|required|email|unique:users,email,' . $id . '|unique:stores,email,' . $id,
        'password' => 'nullable|string|min:6|confirmed',
        'latitude_store' => 'nullable|numeric',
        'longitude_store' => 'nullable|numeric',
        'module_id' => 'sometimes|required|integer',
        'zone_id' => 'sometimes|required|integer',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 422);
    }

    $user = User::find($id);
    $store = Stores::where('email', $user->email)->first();

    if (!$user || !$store) {
        return response()->json(['error' => 'User or Store not found.'], 404);
    }

    DB::beginTransaction();
    try {
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('store_logos', 'public');
            $store->logo = $logoPath;
        }

        $hashedPassword = $request->password ? Hash::make($request->password) : $user->password;

        $store->update([
            'store_name' => $request->store_name ?? $store->store_name,
            'address' => $request->address ?? $store->address,
            'f_name' => $request->f_name ?? $store->f_name,
            'l_name' => $request->l_name ?? $store->l_name,
            'phone' => $request->phone ?? $store->phone,
            'email' => $request->email ?? $store->email,
            'password' => $hashedPassword,
            'latitude_store' => $request->latitude_store ?? $store->latitude_store,
            'longitude_store' => $request->longitude_store ?? $store->longitude_store,
            'module_id' => $request->module_id ?? $store->module_id,
            'zone_id' => $request->zone_id ?? $store->zone_id,
        ]);

        $user->update([
            'name' => $request->f_name . ' ' . $request->l_name ?? $user->name,
            'email' => $request->email ?? $user->email,
            'password' => $hashedPassword,
        ]);

        DB::commit();

        return response()->json([
            'message' => 'User and store details updated successfully.',
            'store' => $store,
            'user' => $user
        ], 200);
    } catch (\Exception $e) {
        DB::rollBack();
        return response()->json(['error' => 'Failed to update user.', 'details' => $e->getMessage()], 500);
    }
}



    public function getAllStores()
    {
        $stores = Stores::all();

        if ($stores->isEmpty()) {
            return response()->json([
                'status' => 'error',
                'message' => 'No stores found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Stores retrieved successfully.',
            'data' => $stores
        ], 200);
    }

    // Get store by ID
    public function getStoreById($id)
    {
        $store = Stores::find($id);

        if (!$store) {
            return response()->json([
                'status' => 'error',
                'message' => 'Store not found.'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Store retrieved successfully.',
            'data' => $store
        ], 200);
    }

}

