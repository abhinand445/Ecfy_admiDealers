<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Product;
use App\Models\Cart;

class CartController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function addToCart(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|integer|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'data' => $validator->errors()
            ], 422);
        }

        $product = Product::find($request->product_id);
        if (!$product) {
            return response()->json([
                'status' => false,
                'message' => 'Product not found',
                'data' => null
            ], 404);
        }



        $cart = Cart::updateOrCreate(
            [
                'user_id' => Auth::id(),
                'product_id' => $request->product_id
            ],
            ['quantity' => $request->quantity]
        );

        return response()->json([
            'status' => 'success',
            'message' => 'Product added to cart successfully',
            'data' => $cart
        ], 201);
    }

    public function viewCart()
    {
        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        return response()->json([
            'status' => 'success',
            'message' => 'Cart retrieved successfully',
            'data' => $cartItems
        ], 200);
    }


    public function getCart()
{
    $user = Auth::user(); 

    $cartItems = Cart::where('user_id', $user->id)->with('product')->get();

    return response()->json([
        'status' => 'success',
        'message' => 'Cart items fetched successfully',
        'data' => $cartItems
    ], 200);
}


    public function removeFromCart($id)
    {
        $cartItem = Cart::where('user_id', Auth::id())->where('id', $id)->first();
        if (!$cartItem) {
            return response()->json([
                'status' => false,
                'message' => 'Item not found in cart',
                'data' => null
            ], 404);
        }

        $cartItem->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'Item removed from cart',
            'data' => null
        ], 200);
    }
}
