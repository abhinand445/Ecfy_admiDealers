<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\WeightClassController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\PurchasingController;
use App\Http\Controllers\Api\DealersController;
use App\Http\Controllers\Api\OrdersController;
use App\Http\Controllers\Api\RetailersController;
use App\Http\Controllers\Api\OrderDealersController;
use App\Http\Controllers\Api\UsersController;
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\ZoneController;


// Super Admin login

Route::prefix('admin')->group(function () {
    Route::post('login', [AdminController::class, 'login']);
    Route::post('logout', [AdminController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('register', [AdminController::class, 'register']);
    Route::post('dealers', [DealersController::class, 'store']);
    // Route::post('dealers/login', [AdminController::class, 'login']);

    
});

// Dealers

Route::middleware('auth:sanctum')->post('dealers', [DealersController::class, 'store']);
Route::post('dealers/login', [DealersController::class, 'login']);
Route::post('dealers/logout', [AdminController::class, 'logout'])->middleware('auth:sanctum')->name('dealers.logout');
Route::middleware('auth:sanctum')->get('/admin/dashboard', [AdminController::class, 'dashboard']);  

// Admin Creates Seller

Route::middleware('auth:sanctum')->post('/create-store', [UsersController::class, 'createUsers']);
Route::get('/stores', [UsersController::class, 'getAllStores']); // Get all stores
Route::get('/stores/{id}', [UsersController::class, 'getStoreById']);
Route::post('/user/login', [UsersController::class, 'login']);
Route::post('/update/stores/{id}', [UsersController::class, 'updateUserstore']);


// Protected routes for sellers
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/seller/profile', function (Request $request) {
        return response()->json($request->user());
    });
});

// Products 

// Group routes under authentication middleware
Route::middleware('auth:sanctum')->group(function () {
   
    Route::post('/products', [ProductController::class, 'store']); 
    Route::get('/products', [ProductController::class, 'index']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::put('/products/{id}', [ProductController::class, 'update']); 
    Route::delete('/products/{id}', [ProductController::class, 'destroy']); 
});

// categories 

Route::get('/categories', [CategoryController::class, 'index']);
// Route::post('/categories', [CategoryController::class, 'store']);

// get all zones 

Route::get('/zones', [ZoneController::class, 'index']);
Route::post('/zones', [ZoneController::class, 'store']);
Route::get('/zones/{id}', [ZoneController::class, 'show']);
Route::put('/zones/{id}', [ZoneController::class, 'update']);
Route::delete('/zones/{id}', [ZoneController::class, 'destroy']);

// Oders Deatails

Route::middleware('auth:api')->prefix('orders')->group(function () {
    Route::post('/orders', [OrdersController::class, 'createOrder']);    
    Route::get('/orders', [OrdersController::class, 'getOrders']);     
    Route::get('{id}', [OrdersController::class, 'showOrder']);    
    Route::put('{id}', [OrdersController::class, 'editOrder']);    
    Route::delete('{id}', [OrdersController::class, 'deleteOrder']); 
});
