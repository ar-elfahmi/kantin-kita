<?php

use App\Http\Controllers\Admin\ArtikelController as AdminArtikelController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\TransaksiController as AdminTransaksiController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\VendorUserController as AdminVendorUserController;
use App\Http\Controllers\ArtikelController;
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

Route::get('/artikel', [ArtikelController::class, 'index'])->name('artikel.index');
Route::get('/artikel/{artikel:slug}', [ArtikelController::class, 'show'])->name('artikel.show');

Route::get('/vendor', [VendorController::class, 'index'])->name('vendor');
Route::get('/vendor/{id}/menu', [VendorController::class, 'showMenu'])->name('menu');
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout');
Route::get('/order/{pesanan}', [CheckoutController::class, 'success'])->name('order.success');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/menu', [DashboardController::class, 'menuList'])->name('dashboard.menu');
    Route::get('/dashboard/menu/scan', [PriceTagController::class, 'scan'])->name('dashboard.menu.scan');
    Route::get('/dashboard/pesanan', [DashboardController::class, 'pesananList'])->name('dashboard.orders');
    Route::post('/dashboard/pesanan/{pesanan}/selesai', [DashboardController::class, 'markAsDone'])->name('dashboard.orders.complete');
    Route::post('/dashboard/menu/store', [DashboardController::class, 'storeMenu'])->name('dashboard.menu.store');
    Route::put('/dashboard/menu/{menu}', [DashboardController::class, 'updateMenu'])->name('dashboard.menu.update');
    Route::delete('/dashboard/menu/{menu}', [DashboardController::class, 'destroyMenu'])->name('dashboard.menu.destroy');
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

Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    Route::get('/users', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/users/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/users', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminUserController::class, 'edit'])->withTrashed()->name('users.edit');
    Route::put('/users/{user}', [AdminUserController::class, 'update'])->withTrashed()->name('users.update');
    Route::delete('/users/{user}', [AdminUserController::class, 'destroy'])->name('users.destroy');
    Route::post('/users/{user}/restore', [AdminUserController::class, 'restore'])->withTrashed()->name('users.restore');
    Route::post('/users/{user}/reset-password', [AdminUserController::class, 'resetPassword'])->withTrashed()->name('users.reset-password');

    Route::get('/artikel', [AdminArtikelController::class, 'index'])->name('artikel.index');
    Route::get('/artikel/create', [AdminArtikelController::class, 'create'])->name('artikel.create');
    Route::post('/artikel', [AdminArtikelController::class, 'store'])->name('artikel.store');
    Route::get('/artikel/{artikel}/edit', [AdminArtikelController::class, 'edit'])->name('artikel.edit');
    Route::put('/artikel/{artikel}', [AdminArtikelController::class, 'update'])->name('artikel.update');
    Route::delete('/artikel/{artikel}', [AdminArtikelController::class, 'destroy'])->name('artikel.destroy');
    Route::post('/artikel/{artikel}/archive', [AdminArtikelController::class, 'archive'])->name('artikel.archive');

    Route::get('/vendor-users', [AdminVendorUserController::class, 'index'])->name('vendor-users.index');
    Route::get('/vendor-users/create', [AdminVendorUserController::class, 'create'])->name('vendor-users.create');
    Route::post('/vendor-users', [AdminVendorUserController::class, 'store'])->name('vendor-users.store');
    Route::get('/vendor-users/{user}/edit', [AdminVendorUserController::class, 'edit'])->withTrashed()->name('vendor-users.edit');
    Route::put('/vendor-users/{user}', [AdminVendorUserController::class, 'update'])->withTrashed()->name('vendor-users.update');
    Route::delete('/vendor-users/{user}', [AdminVendorUserController::class, 'destroy'])->name('vendor-users.destroy');
    Route::post('/vendor-users/{user}/restore', [AdminVendorUserController::class, 'restore'])->withTrashed()->name('vendor-users.restore');
    Route::post('/vendor-users/{user}/reset-password', [AdminVendorUserController::class, 'resetPassword'])->withTrashed()->name('vendor-users.reset-password');

    Route::get('/transaksi', [AdminTransaksiController::class, 'index'])->name('transaksi.index');
    Route::get('/transaksi/{pesanan}', [AdminTransaksiController::class, 'show'])->name('transaksi.show');
});
