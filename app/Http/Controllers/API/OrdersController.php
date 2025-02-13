<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\User;

class OrdersController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function createOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'payment_method' => 'required|in:cod,online,upi,card,cash',
            'order_type' => 'required|in:delivery,pickup',
            'delivery_man_id' => 'nullable|integer|exists:users,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 422);
        }

        $user = Auth::user();

        // Fetch user address from database
        $userData = User::where('id', $user->id)->select('address')->first();

        if (!$userData || !$userData->address) {
            return response()->json([
                'status' => false,
                'message' => 'User address is required',
                'data' => null
            ], 400);
        }

        $product = Product::find($request->product_id);
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
                'data' => null
            ], 404);
        }

        // Calculate price, tax, and discount
        $totalPrice = $product->price * $request->quantity;
        $totalTaxAmount = ($product->tax_percentage / 100) * $totalPrice;
        $couponDiscountAmount = ($product->discount_percentage / 100) * $totalPrice;
        $finalAmount = $totalPrice + $totalTaxAmount - $couponDiscountAmount;

        // Create Order
        $order = Order::create([
            'user_id' => $user->id,
            'total_price' => $finalAmount,
            'total_tax_amount' => $totalTaxAmount,
            'coupon_discount_amount' => $couponDiscountAmount,
            'payment_method' => $request->payment_method,
            'payment_status' => 'pending',
            'order_status' => 'pending',
            'order_type' => $request->order_type,
            'delivery_address' => $userData->address,
            'delivery_man_id' => $request->delivery_man_id,
        ]);

        // Store ordered product in OrderItem table
        OrderItem::create([
            'order_id' => $order->id,
            'product_id' => $product->id,
            'quantity' => $request->quantity,
            'price' => $product->price,
            'tax_amount' => $totalTaxAmount,
            'discount_amount' => $couponDiscountAmount,
            'total_price' => $totalPrice,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order placed successfully',
            'data' => $order
        ], 201);
    }
}
