<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Models\Modules;
use App\Models\Zone;
use App\Models\Store;
use App\Models\Dealer;

class DealersController extends Controller
{
    public function createDealers()
    {
        
          $modules=Modules::all();
          $zones=Modules::all();
          $stores=Modules::all();
          


        return view('dealers.create', compact('modules', 'zones', 'stores'));
    }

    // Store dealer details
    public function store(Request $request)
    {
        // No need to switch; use default database (esifyadmin)
        $validated = $request->validate([
            'f_name' => 'required|string|max:255',
            'l_name' => 'nullable|string|max:255',
            'address' => 'required|string|max:500',
            'phone' => 'required|string|regex:/^[0-9]{10}$/|unique:dealers,phone',
            'email' => 'required|email|unique:dealers,email',
            'module_id' => 'required|exists:modules,id',
            'zone_id' => 'required|exists:zones,id',
            'status' => 'required|boolean',
            'latitude' => 'nullable|numeric|between:-90,90',
            'longitude' => 'nullable|numeric|between:-180,180',
        ]);

        // Store dealer data in the default database
        Dealer::create($validated);

        return redirect()->route('dealers.create')->with('success', 'Dealer created successfully!');
    }
}
