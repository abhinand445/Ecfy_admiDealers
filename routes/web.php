<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DealersController;

// Default Route to Login Page
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('auth:admin')->group(function () {
    Route::get('/dashboard', function () {
        return view('index');
    })->name('dashboard');
});



// Admin Index Route
Route::get('/index', [AdminController::class, 'index'])->name('index');
Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');



//Authentication Routes

Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/superadmin/dashboard', [SuperAdminController::class, 'index'])->middleware(['auth', 'superadmin'])->name('superadmin.dashboard');
Route::get('/admin/dashboard', [AdminController::class, 'index'])->middleware(['auth', 'admin'])->name('admin.dashboard');
Route::get('/seller/dashboard', [SellerController::class, 'index'])->middleware(['auth', 'seller'])->name('seller.dashboard');



// Dealer Login Routes
Route::get('/dealer/login', [DealersController::class, 'showLoginForm'])->name('dealer.login');
Route::post('/dealer/login', [DealersController::class, 'login'])->name('dealer.login.submit');
Route::post('/dealer/logout', [DealersController::class, 'logout'])->name('dealer.logout');

Route::get('createDealers', [DealersController::class, 'createDealers'])->name('dealers.create');
Route::post('dealers', [DealersController::class, 'store'])->name('dealers.store');
Route::get('/dealers', [DealersController::class, 'index'])->name('dealers.index');


// Dashboard and Profile Routes (Middleware based on role)
Route::middleware(['auth'])->group(function () {

    // Role-based Access for SuperAdmin
    Route::middleware(['role:superAdmin'])->group(function () {
        Route::get('/superadmin/dashboard', [DashboardController::class, 'index']);
    });

    // Role-based Access for Admin (Dealers)
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin/dashboard', [DashboardController::class, 'dashboard'])->name('admin.index');
    });

    // Role-based Access for Sellers
    Route::middleware(['role:sellers'])->group(function () {
        Route::get('/seller/dashboard', [DashboardController::class, 'index'])->name('seller.index');
    });

    // Common Routes for Profile and Change Password (Available to all authenticated users)
    Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
    Route::get('/change-password', [DashboardController::class, 'changePassword'])->name('change-password');
});

// Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
// Route::post('/register', [AuthController::class, 'register']);

// Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Route::post('/login', [AuthController::class, 'login']);

// Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Route::middleware(['auth'])->group(function () {
//     Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
//     Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
//     Route::get('/change-password', [DashboardController::class, 'changePassword'])->name('change-password');
// });



// dealers 


// Route::get('createDealers', [DealersController::class, 'createDealers'])->name('dealers.create');
// Route::post('/dealers/store', [DealersController::class, 'store'])->name('dealers.store');

// Route for the dealers index page
Route::get('/dealers', [DealersController::class, 'index'])->name('dealers.index');

