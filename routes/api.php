<?php

use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

Route::post('/checkout', [CheckoutController::class, 'store']);
Route::post('/checkout/update-status', [CheckoutController::class, 'updateStatus']);
Route::post('/midtrans/notification', [CheckoutController::class, 'notification']);
