<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
{
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

   
    $role = 'sellers'; 

    if (Auth::check()) {
        if (Auth::user()->role === 'superAdmin') {
            $role = 'admin'; 
        } elseif (Auth::user()->role === 'admin') {
            $role = 'sellers'; 
        }
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $role,
    ]);

    Auth::guard('web')->login($user);

    return redirect()->route('index');
}


    public function showLoginForm()
    {
        return view('auth.login');
    }

  public function login(Request $request)
{
    $validator = Validator::make($request->all(), [
        'email' => 'required|string|email|max:255',
        'password' => 'required|string|min:8',
    ]);

    if ($validator->fails()) {
        return redirect()->back()->withErrors($validator)->withInput();
    }

    if (Auth::guard('web')->attempt($request->only('email', 'password'))) {
       
        if (Auth::user()->role === 'superAdmin') {
            return redirect()->route('index');
        } elseif (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif (Auth::user()->role === 'seller') {
            return redirect()->route('seller.dashboard');
        } else {
            return redirect()->route('login')->withErrors(['role' => 'Unauthorized access.']);
        }
    }

    return redirect()->back()->withErrors(['email' => 'Invalid credentials.']);
}


  public function logout(Request $request)
    {
        Auth::guard('web')->logout();  
        $request->session()->invalidate(); 
        $request->session()->regenerateToken();  

        return redirect()->route('login');  
    }

}
