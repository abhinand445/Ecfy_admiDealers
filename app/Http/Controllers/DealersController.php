<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modules;
use App\Models\Zone;
use App\Models\Store;
use App\Models\Dealer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class DealersController extends Controller
{
    /**
     * Display a listing of the dealers.
     */
    public function index()
    {
        $dealers = Dealer::all();
        return view('dealers.index', compact('dealers'));
    }

    /**
     * Show the form for creating a new dealer.
     */
    public function createDealers()
    {
        $stores = Store::all();
        $modules = Modules::all();
        $zones = Zone::all();

        return view('dealers.create', compact('stores', 'modules', 'zones'));
    }

    /**
     * Store a newly created dealer in storage.
     */
    public function store(Request $request)
    {
        // Validate request
        $validator = Validator::make($request->all(), [
            'store_id' => 'required|exists:stores,id',
            'address' => 'required|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'module_id' => 'required|exists:modules,id',
            'zone_id' => 'required|exists:zones,id',
            'latitude_store' => 'required|numeric',
            'longitude_store' => 'required|numeric',
            'f_name' => 'required|string|max:255',
            'l_name' => 'required|string|max:255',
            'phone' => 'required|digits:10|unique:dealers,phone',
            'email' => 'required|email|unique:dealers,email',
            'password' => 'required|string|min:6|confirmed',
        ]);

         

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Handle file upload
        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('dealer_logos', 'public');
        }

        // Create the dealer
        Dealer::create([
            'store_id' => $request->store_id,
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
            'password' => Hash::make($request->password), // Hash password
        ]);

        return redirect()->route('dealers.index')->with('success', 'Dealer added successfully.');
       
    }

    /**
     * Show the dealer login form.
     */
    public function showLoginForm()
    {
        return view('auth.dealer_login');
    }

    /**
     * Handle dealer login.
     */
    public function login(Request $request)
    {
        // Validate login credentials
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ]);

        if (Auth::guard('dealer')->attempt($request->only('email', 'password'))) {
            $user = Auth::guard('dealer')->user();

            // Redirect based on role
            if ($user->role === 'admin') {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome to the Admin Dashboard!');
            } elseif ($user->role === 'superadmin') {
                return redirect()->route('superadmin.dashboard')->with('success', 'Welcome to the Super Admin Dashboard!');
            } elseif ($user->role === 'dealer') {
                return redirect()->route('dealer.dashboard')->with('success', 'Welcome to the Dealer Dashboard!');
            } else {
                Auth::guard('dealer')->logout();
                return redirect()->route('dealer.login')->withErrors(['error' => 'Unauthorized access.']);
            }
        }

        return back()->withErrors(['error' => 'Invalid email or password.']);
    }

    /**
     * Handle dealer logout.
     */
    public function logout()
    {
        Auth::guard('dealer')->logout();
        return redirect()->route('dealer.login')->with('success', 'Logged out successfully.');
    }
}
