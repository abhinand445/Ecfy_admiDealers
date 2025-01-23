<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modules;
use App\Models\Zone;
use App\Models\Store;
use App\Models\Dealer;

class DealersController extends Controller
{
    // Show the form to create a new dealer
    public function createDealers() {
        $modules = Modules::all(); 
        $zones = Zone::all();
        $stores = Store::all();

        return view('dealers.create', compact('modules', 'zones', 'stores'));
    }

    // Store a newly created dealer in storage
    public function store(Request $request)
    {
        // Validate the incoming request data
        $validated = $request->validate([
            'store_id' => 'required|exists:stores,id', 
            'address' => 'required|string|max:500', 
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'module_id' => 'required|exists:modules,id', 
            'zone' => 'required|exists:zones,id', 
            'latitude_store' => 'required|numeric|between:-90,90', 
            'longitude_store' => 'required|numeric|between:-180,180', 
            'f_name' => 'required|string|max:255', 
            'l_name' => 'nullable|string|max:255', 
            'phone' => 'required|string|regex:/^[0-9]{10}$/|unique:dealers,phone', 
            'email' => 'required|email|unique:dealers,email',
        ]);

        
        Dealer::create($validated);
        
        return redirect()->route('dealers.create')->with('success', 'Dealer created successfully!');
    }
}
