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



Route::prefix('admin')->group(function () {
    Route::post('login', [AdminController::class, 'login']);
    Route::post('logout', [AdminController::class, 'logout'])->middleware('auth:sanctum');
    Route::post('dealers', [DealersController::class, 'store']);
    // Route::post('dealers/login', [AdminController::class, 'login']);

    
});

Route::middleware('auth:sanctum')->post('dealers', [DealersController::class, 'store']);

Route::post('dealers/login', [DealersController::class, 'login']);


// Logout Route for Dealers
Route::post('dealers/logout', [AdminController::class, 'logout'])->middleware('auth:sanctum')->name('dealers.logout');

Route::middleware('auth:sanctum')->get('/admin/dashboard', [AdminController::class, 'dashboard']);  

// Admin Creates Seller
Route::middleware('auth:sanctum')->post('/create-seller', [UsersController::class, 'createSeller']);


Route::post('/seller/login', [UsersController::class, 'login']);

// Protected routes for sellers
Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/seller/profile', function (Request $request) {
        return response()->json($request->user());
    });
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/products', [ProductController::class, 'create']);
    Route::get('/products', [ProductController::class, 'index']); 
    Route::get('/products/{id}', [ProductController::class, 'show']);
    Route::put('/products/{id}', [ProductController::class, 'update']); 
    Route::delete('/products/{id}', [ProductController::class, 'destroy']); 
});




// Route::prefix('admin')->group(function () {

//        Route::post('/dealers', [DealersController::class, 'store']);
//        Route::get('/dealers', [DealersController::class, 'index']);

//     //    Route::post('/dealers/login', [DealersController::class, 'login']);
//        Route::post('/dealers/logout', [DealersController::class, 'logout']);

//     // product 
   
//     Route::get('/products', [ProductController::class, 'index']); 
//     Route::post('/products', [ProductController::class, 'store']);
//     Route::get('/products/{id}', [ProductController::class, 'show']);
//     Route::put('/products/{id}', [ProductController::class, 'update']);
//     Route::delete('/products/{id}', [ProductController::class, 'destroy']);


//     // category 
//     Route::get('/categories', [CategoryController::class, 'index']);
//     Route::post('/category', [CategoryController::class, 'store']);
//     // purchasing 
//     Route::post('purchases',[PurchasingController::class, 'store']);

//     // Route to get all weight classes
//     Route::get('weight-classes', [WeightClassController::class, 'index']);

//     // Route to create a new weight class
//     Route::post('weight-classes', [WeightClassController::class, 'store']);

//     // Orders routes
//     Route::get('orders', [OrdersController::class, 'index']);
//     Route::post('orders', [OrdersController::class, 'store']);

//     // Retailers routes
//     Route::get('retailers', [RetailersController::class, 'index']);
//     Route::post('retailers', [RetailersController::class, 'store']);

//     // Order-Dealers routes
//     Route::get('order-dealers', [OrderDealersController::class, 'index']);
//     Route::post('order-dealers', [OrderDealersController::class, 'store']);

//     // Despatch routes
//     // Route::get('despatches', [DespatchController::class, 'index']);
//     // Route::post('despatches', [DespatchController::class, 'store']);

// });

// Route::prefix('dealers')->group(function () {
//     Route::get('/', [DealersController::class, 'index']);         
//     Route::post('/', [DealersController::class, 'store']);        
//     Route::get('/{id}', [DealersController::class, 'show']);      
//     Route::put('/{id}', [DealersController::class, 'update']);   
//     Route::delete('/{id}', [DealersController::class, 'destroy']);
// });
