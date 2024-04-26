<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::get('/', function () {
    return Inertia::render('App');
});

Route::get('/checkout', function () {
        return Inertia::render('Checkout/Checkout');
    })->name('checkout');

