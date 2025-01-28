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

// Public routes
Route::post('/register', [RegisterController::class, 'register']);
Route::post('/login', [LoginController::class, 'login']);

// Protected routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [RegisterController::class, 'logout']);
    Route::get('/profile', [RegisterController::class, 'profile']);

//     Route::post('/dealers', [DealersController::class, 'store']);
//    // Route for listing all dealers

//     Route::get('/dealers', [DealersController::class, 'index']);
    // Route::get('/weightclass', [WeightClassController::class, 'index']);
    // Route::post('/weightclasscreate', [WeightClassController::class, 'store']);
    
    // Route::get('/category', [CategoryController::class, 'index']);
    // Route::post('/products', [ProductController::class, 'store']);
    // Route::post('/purchaising', [PurchasingController::class, 'store']);
});



Route::prefix('admin')->group(function () {
    Route::post('/dealers', [DealersController::class, 'store']); 
    Route::get('/dealers', [DealersController::class, 'index']);

    // product 
   
    Route::get('/products', [ProductController::class, 'index']); 
    Route::post('/products', [ProductController::class, 'store']);
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::put('/products/{id}', [ProductController::class, 'update']);
    Route::delete('/products/{id}', [ProductController::class, 'destroy']);


    // category 
    Route::get('/categories', [CategoryController::class, 'index']);
    Route::post('/category', [CategoryController::class, 'store']);
    // purchasing 
    Route::post('purchases',[PurchasingController::class, 'store']);

    // Route to get all weight classes
    Route::get('weight-classes', [WeightClassController::class, 'index']);

    // Route to create a new weight class
    Route::post('weight-classes', [WeightClassController::class, 'store']);

    // Orders routes
    Route::get('orders', [OrdersController::class, 'index']);
    Route::post('orders', [OrdersController::class, 'store']);

    // Retailers routes
    Route::get('retailers', [RetailersController::class, 'index']);
    Route::post('retailers', [RetailersController::class, 'store']);

    // Order-Dealers routes
    Route::get('order-dealers', [OrderDealersController::class, 'index']);
    Route::post('order-dealers', [OrderDealersController::class, 'store']);

    // Despatch routes
    // Route::get('despatches', [DespatchController::class, 'index']);
    // Route::post('despatches', [DespatchController::class, 'store']);

});
