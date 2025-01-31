<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Sellers;

class UsersController extends Controller
{
    
    public function createSeller(Request $request)
    {
       
        if (!Auth::check() || Auth::user()->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized. Only admins can create sellers.'], 403);
        }

        $validator = Validator::make($request->all(), [
            'store_name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|email|unique:sellers,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

    
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('seller_logos', 'public');
        }

       
        $seller = new Sellers();
        $seller->store_name = $request->store_name;
        $seller->address = $request->address;
        $seller->logo = $logoPath;
        $seller->f_name = $request->f_name;
        $seller->l_name = $request->l_name;
        $seller->phone = $request->phone;
        $seller->email = $request->email;
        $seller->password = Hash::make($request->password); 
        $seller->save();

        $user = new User();
        $user->name = $request->f_name . ' ' . $request->l_name; 
        $user->email = $request->email;
        $user->password = Hash::make($request->password); 
        $user->role = 'seller'; 
        $user->save();

        $token = $user->createToken('SellerToken')->plainTextToken;

        return response()->json([
            'message' => 'Seller created successfully by admin.',
            'token' => $token,
            'seller' => $seller
        ], 201);
    }



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
}
