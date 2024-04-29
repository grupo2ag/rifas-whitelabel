<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('Site/Home/Home');
})->name('index');


Route::get('/checkout', function () {
        return Inertia::render('Site/Checkout/Checkout');
    })->name('checkout');


Route::get('/account', function () {
    return Inertia::render('Site/Account/Account');
})->name('account');
