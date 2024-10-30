<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoadController;
use App\Http\Controllers\CarrierController;
use App\Http\Controllers\CostumerController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Rute pentru autentificare
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Rute protejate care necesită autentificare
Route::middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Loads - accesibile pentru toate rolurile
    Route::resource('loads', LoadController::class);
    
    // Carriers - accesibile pentru ops și csr
    Route::middleware(['role:ops,csr'])->group(function () {
        Route::resource('carriers', CarrierController::class);
    });
    
    // Customers - accesibile pentru sales și csr
    Route::middleware(['role:sales,csr'])->group(function () {
        Route::resource('costumers', CostumerController::class);
    });
    
    // Users - doar pentru admin
    Route::middleware(['role:admin'])->group(function () {
        Route::resource('users', UserController::class);
    });
});