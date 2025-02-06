<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\JsonResponse;

class ZoneController extends Controller
{

    public function index(): JsonResponse
    {
        
        $zones = Zone::all();

        return response()->json(['data' => $zones], 200);
    }

    public function store(Request $request): JsonResponse
    {
        
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'coordinates' => 'required', 
            'status' => 'required|boolean',
            'store_wise_topic' => 'nullable|string|max:255',
            'customer_wise_topic' => 'nullable|string|max:255',
            'deliveryman_wise_topic' => 'nullable|string|max:255',
            'cash_on_delivery' => 'required|boolean',
            'digital_payment' => 'required|boolean',
            'increased_delivery_fee' => 'nullable|numeric',
            'increased_delivery_fee_status' => 'nullable|boolean',
            'increase_delivery_charge_message' => 'nullable|string',
            'offline_payment' => 'required|boolean',
        ]);

        if ($validator->fails()) {
          
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $zone = Zone::create($request->all());

      
        return response()->json(['data' => $zone], 201);
    }

    public function show($id): JsonResponse
    {
      
        $zone = Zone::find($id);

        if (!$zone) {
           
            return response()->json(['error' => 'Zone not found'], 404);
        }

        
        return response()->json(['data' => $zone], 200);
    }

   
    public function update(Request $request, $id): JsonResponse
    {

        $zone = Zone::find($id);

        if (!$zone) {
            
            return response()->json(['error' => 'Zone not found'], 404);
        }

       
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|required|string|max:255',
            'coordinates' => 'sometimes|required', 
            'status' => 'sometimes|required|boolean',
            'store_wise_topic' => 'nullable|string|max:255',
            'customer_wise_topic' => 'nullable|string|max:255',
            'deliveryman_wise_topic' => 'nullable|string|max:255',
            'cash_on_delivery' => 'sometimes|required|boolean',
            'digital_payment' => 'sometimes|required|boolean',
            'increased_delivery_fee' => 'nullable|numeric',
            'increased_delivery_fee_status' => 'nullable|boolean',
            'increase_delivery_charge_message' => 'nullable|string',
            'offline_payment' => 'sometimes|required|boolean',
        ]);

        if ($validator->fails()) {
            
            return response()->json(['errors' => $validator->errors()], 400);
        }

        
        $zone->update($request->all());

        return response()->json(['data' => $zone], 200);
    }


    public function destroy($id): JsonResponse
    {
       
        $zone = Zone::find($id);

        if (!$zone) {
            
            return response()->json(['error' => 'Zone not found'], 404);
        }

        
        $zone->delete();

            
        return response()->json(['message' => 'Zone deleted successfully'], 200);
    }
}
