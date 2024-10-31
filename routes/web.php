<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\LoadController;
use App\Http\Controllers\CarrierController;
use App\Http\Controllers\CostumerController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\LocationController;
use Illuminate\Support\Facades\Route;

// Rute pentru autentificare
Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Rute pentru loads - accesibile tuturor
    Route::resource('loads', LoadController::class);

    // Rute pentru carriers - doar pentru ops și csr
    Route::middleware('can:access-carriers')->group(function () {
        Route::resource('carriers', CarrierController::class);
    });

    // Rute pentru customers - doar pentru sales și csr
    Route::middleware('can:access-customers')->group(function () {
        Route::resource('costumers', CostumerController::class);
    });

    // Rute pentru useri - doar pentru admin
    Route::middleware('can:access-admin')->group(function () {
        Route::resource('users', UserController::class);
    });


    Route::controller(LocationController::class)->group(function () {
        Route::get('/locations/search', 'search');
        Route::post('/locations', 'store');
        Route::put('/locations/{location}', 'update');
    });

    Route::get('/search/costumers', [SearchController::class, 'costumers']);
    Route::get('/search/carriers', [SearchController::class, 'carriers']);

});