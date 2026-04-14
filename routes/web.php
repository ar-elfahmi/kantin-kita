<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/vendor', [VendorController::class, 'index'])->name('vendor');
Route::get('/vendor/{id}/menu', [VendorController::class, 'showMenu'])->name('menu');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/pesanan/{pesanan}/selesai', [DashboardController::class, 'markAsDone'])->name('dashboard.orders.complete');
});
