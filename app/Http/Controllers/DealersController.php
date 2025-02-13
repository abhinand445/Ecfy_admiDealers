<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modules;
use App\Models\Zone;
use App\Models\Store;
use App\Models\Dealers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DealersController extends Controller
{
    public function index()
    {
        $dealers = Dealers::all();
        return view('dealers.index', compact('dealers'));
    }

    public function createDealers()
    {
        $modules = Modules::all();
        $zones = Zone::all();
        return view('dealers.create', compact('modules', 'zones'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'store_name' => 'required|string|max:255',
            'address' => 'required|string',
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'module_id' => 'required|exists:modules,id',
            'zone_id' => 'required|exists:zones,id',
            'latitude_store' => 'required',
            'longitude_store' => 'required',
            'f_name' => 'required|string|max:100',
            'l_name' => 'required|string|max:100',
            'phone' => 'required|numeric',
            'email' => 'required|email|unique:dealers,email',
            'password' => 'required|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $logoPath = $request->file('logo')->store('dealer_logos', 'public');

        Dealers::create([
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
            'password' => Hash::make($request->password),
        ]);
       

        return redirect()->route('dealers.index')->with('success', 'Dealer added successfully.');
    }

    public function showLoginForm()
    {
        return view('auth.dealer_login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('dealer')->attempt($request->only('email', 'password'))) {
            $user = Auth::guard('dealer')->user();

            switch ($user->role) {
                case 'admin':
                    return redirect()->route('admin.dashboard')->with('success', 'Welcome to the Admin Dashboard!');
                case 'superadmin':
                    return redirect()->route('superadmin.dashboard')->with('success', 'Welcome to the Super Admin Dashboard!');
                case 'dealer':
                    return redirect()->route('dealer.dashboard')->with('success', 'Welcome to the Dealer Dashboard!');
                default:
                    Auth::guard('dealer')->logout();
                    return redirect()->route('dealer.login')->withErrors(['error' => 'Unauthorized access.']);
            }
        }

        return back()->withErrors(['error' => 'Invalid email or password.']);
    }

    public function logout()
    {
        Auth::guard('dealer')->logout();
        return redirect()->route('dealer.login')->with('success', 'Logged out successfully.');
    }
}
