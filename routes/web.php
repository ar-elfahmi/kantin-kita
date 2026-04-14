<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
Route::get('/login', function () {
    return view('login');
})->name('login');
Route::get('/dashboard', function () {
    return view('dashboard-vendor');
});


Route::get('/vendor', function () {
    return view('select-vendor');
})->name('vendor');
Route::get('/menu', function () {
    return view('menu-vendor');
})->name('menu');
Route::get('/checkout', function () {
    return view('checkout');
})->name('checkout');
