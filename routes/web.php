<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KunjunganTokoController;
use App\Http\Controllers\PriceTagController;
use App\Http\Controllers\VendorController;
use Illuminate\Support\Facades\Route;

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', function () {
    return view('about');
})->name('about');

Route::get('/vendor', [VendorController::class, 'index'])->name('vendor');
Route::get('/vendor/{id}/menu', [VendorController::class, 'showMenu'])->name('menu');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::get('/order/{pesanan}', [CheckoutController::class, 'success'])->name('order.success');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/menu', [DashboardController::class, 'menuList'])->name('dashboard.menu');
    Route::get('/dashboard/menu/scan', [PriceTagController::class, 'scan'])->name('dashboard.menu.scan');
    Route::post('/dashboard/pesanan/{pesanan}/selesai', [DashboardController::class, 'markAsDone'])->name('dashboard.orders.complete');
    Route::get('/api/checkout/by-order-id/{orderId}', [CheckoutController::class, 'lookupByOrderId']);
    Route::get('/api/menu/by-id-barang/{idBarang}', [PriceTagController::class, 'lookupByIdBarang'])->name('api.menu.by-id-barang');
    Route::get('/menu/{menu}/price-tag', [PriceTagController::class, 'generate'])->name('menu.price-tag');

    Route::prefix('dashboard/customer')->name('dashboard.customer.')->group(function () {
        Route::get('/', [CustomerController::class, 'index'])->name('index');
        Route::get('/create-blob', [CustomerController::class, 'createBlob'])->name('create-blob');
        Route::post('/store-blob', [CustomerController::class, 'storeBlob'])->name('store-blob');
        Route::get('/create-path', [CustomerController::class, 'createPath'])->name('create-path');
        Route::post('/store-path', [CustomerController::class, 'storePath'])->name('store-path');
        Route::get('/{customer}/photo', [CustomerController::class, 'photoBlob'])->name('photo');
    });

    Route::prefix('dashboard/kunjungan')->name('dashboard.kunjungan.')->group(function () {
        Route::get('/', [KunjunganTokoController::class, 'index'])->name('index');
        Route::get('/toko/create', [KunjunganTokoController::class, 'tokoCreate'])->name('toko.create');
        Route::post('/toko/store', [KunjunganTokoController::class, 'tokoStore'])->name('toko.store');
        Route::get('/toko/{lokasi_toko}/qr', [KunjunganTokoController::class, 'tokoQr'])->name('toko.qr');
        Route::get('/scan', [KunjunganTokoController::class, 'scan'])->name('scan');
        Route::get('/api/toko/{barcode}', [KunjunganTokoController::class, 'lookupToko'])->name('api.toko');
        Route::post('/visit', [KunjunganTokoController::class, 'visitStore'])->name('visit.store');
    });
});
