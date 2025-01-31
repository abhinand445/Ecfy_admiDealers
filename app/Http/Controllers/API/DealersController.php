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
            return response()->json(['errors' => $validator->errors()], 422);
        }

        
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('dealer_logos', 'public');
        }

        
        $dealer = new Dealers();
        $dealer->store_name = $request->store_name;
        $dealer->address = $request->address;
        $dealer->logo = $logoPath;
        $dealer->module_id = $request->module_id;
        $dealer->zone_id = $request->zone_id;
        $dealer->latitude_store = $request->latitude_store;
        $dealer->longitude_store = $request->longitude_store;
        $dealer->f_name = $request->f_name;
        $dealer->l_name = $request->l_name;
        $dealer->phone = $request->phone;
        $dealer->email = $request->email;
        $dealer->password = bcrypt($request->password); 
        $dealer->save();

    
        $user = new User();
        $user->name = $request->f_name . ' ' . $request->l_name;  
        $user->email = $request->email;
        $user->password = bcrypt($request->password);  
        $user->role = 'admin'; 
        $user->save();

        $token = $user->createToken('DealerToken')->plainTextToken;

        
        return response()->json([
            'message' => 'Dealer created successfully and added to the users table.',
            'token' => $token
        ], 201);
    }
}
