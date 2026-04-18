<?php

use App\Http\Controllers\ChatbotController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

Route::post('/checkout', [CheckoutController::class, 'store']);
Route::post('/checkout/update-status', [CheckoutController::class, 'updateStatus']);
Route::post('/midtrans/notification', [CheckoutController::class, 'notification']);
Route::post('/chatbot/respond', [ChatbotController::class, 'respond'])->name('chatbot.respond');
