<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use App\Models\Modules;
use App\Models\Zone;
use App\Models\Store;
use App\Models\Dealers;

class DealersController extends Controller
{
    public function createDealers()
    {
        
          $modules=Modules::all();
          $zones=Zone::all();
          $stores=Store::all();

        return view('dealers.create', compact('modules', 'zones', 'stores'));
    }

    // Store dealer details
    public function store(Request $request)
    {
       
     $validated = $request->validate([
    'f_name' => 'required|string|max:255',
    'l_name' => 'nullable|string|max:255',
    'address' => 'required|string|max:500',
    'phone' => 'required|string|regex:/^[0-9]{10}$/|unique:dealers,phone',
    'email' => 'required|email|unique:dealers,email',
    'module_id' => 'required|exists:ecfy_store.modules,id', 
    'zone_id' => 'required|exists:ecfy_store.zones,id',
    'status' => 'required|boolean',
    'latitude' => 'nullable|numeric|between:-90,90',
    'longitude' => 'nullable|numeric|between:-180,180',

   ]);



        // Store dealer data in the default database
        Dealers::create($validated);

        return redirect()->route('dealers.create')->with('success', 'Dealer created successfully!');
    }
}
