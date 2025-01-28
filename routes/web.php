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



Route::get('/register', [AuthController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');
Route::get('/profile', [DashboardController::class, 'profile'])->name('profile');
Route::get('/change-password', [DashboardController::class, 'changePassword'])->name('change-password');



// dealers 


Route::get('createDealers', [DealersController::class, 'createDealers'])->name('dealers.create');
Route::post('/dealers/store', [DealersController::class, 'store'])->name('dealers.store');

// Route for the dealers index page
Route::get('/dealers', [DealersController::class, 'index'])->name('dealers.index');

