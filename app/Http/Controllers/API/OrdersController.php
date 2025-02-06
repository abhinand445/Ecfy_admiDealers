<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Order;
use App\Models\Product;

class OrdersController extends Controller
{
    /**
     * Create an order for the authenticated user.
     */
    public function createOrder(Request $request)
    {
        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',  // Ensure product_id exists in the products table
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'total_tax_amount' => 'nullable|numeric|min:0',
            'coupon_discount_amount' => 'nullable|numeric|min:0',
            'payment_method' => 'required|in:cod,online,upi,card,cash',
            'payment_status' => 'required|in:pending,paid,failed',
            'order_status' => 'required|in:pending,confirmed,cancelled,delivered',
            'order_type' => 'required|in:delivery,pickup',
            'delivery_address' => 'required|string|max:255',
            'delivery_man_id' => 'nullable|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 422);
        }

        try {
            // Create the order using the authenticated user's ID
            $order = Order::create([
                'user_id' => auth()->id(),  // Automatically assign user_id from authenticated user
                'product_id' => $request->product_id,  // Ensure product_id is passed
                'quantity' => $request->quantity,
                'total_price' => $request->total_price,
                'total_tax_amount' => $request->total_tax_amount,
                'coupon_discount_amount' => $request->coupon_discount_amount,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_status,
                'order_status' => $request->order_status,
                'order_type' => $request->order_type,
                'delivery_address' => $request->delivery_address,
                'delivery_man_id' => $request->delivery_man_id,
                'order_date' => now(),
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Order created successfully.',
                'order' => $order
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to create order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

     /**
     * List all orders.
     */
    public function getOrders()
    {
        try {
            $orders = Order::with(['user', 'product'])->get();  // Include relationships if needed

            return response()->json([
                'status' => true,
                'orders' => $orders
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to retrieve orders',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Show a specific order.
     */
    public function showOrder($id)
    {
        try {
            $order = Order::with(['user', 'product'])->findOrFail($id);

            return response()->json([
                'status' => true,
                'order' => $order
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Edit an existing order.
     */
    public function editOrder(Request $request, $id)
    {
        // Validate the incoming data
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'total_price' => 'required|numeric|min:0',
            'total_tax_amount' => 'nullable|numeric|min:0',
            'coupon_discount_amount' => 'nullable|numeric|min:0',
            'payment_method' => 'required|in:cod,online,upi,card,cash',
            'payment_status' => 'required|in:pending,paid,failed',
            'order_status' => 'required|in:pending,confirmed,cancelled,delivered',
            'order_type' => 'required|in:delivery,pickup',
            'delivery_address' => 'required|string|max:255',
            'delivery_man_id' => 'nullable|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 422);
        }

        try {
            $order = Order::findOrFail($id);

            // Update order details
            $order->update([
                'product_id' => $request->product_id,
                'quantity' => $request->quantity,
                'total_price' => $request->total_price,
                'total_tax_amount' => $request->total_tax_amount,
                'coupon_discount_amount' => $request->coupon_discount_amount,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_status,
                'order_status' => $request->order_status,
                'order_type' => $request->order_type,
                'delivery_address' => $request->delivery_address,
                'delivery_man_id' => $request->delivery_man_id,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Order updated successfully.',
                'order' => $order
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to update order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Delete an order.
     */
    public function deleteOrder($id)
    {
        try {
            $order = Order::findOrFail($id);

            // Delete the order
            $order->delete();

            return response()->json([
                'status' => true,
                'message' => 'Order deleted successfully.'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Failed to delete order',
                'error' => $e->getMessage()
            ], 500);
        }
    }

}
