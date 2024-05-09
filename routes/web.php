<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Panel/User/Dashboard');
    })->name('dashboard');

    Route::prefix('/campaign')->name('campaign.')->group(function () {
        Route::get('/index', function () {
            return Inertia::render('Panel/User/Campaign/Campaign');
        })->name('index');

        Route::get('/create', function () {
            return Inertia::render('Panel/User/Campaign/CampaignCreate');
        })->name('create');
    });
});

Route::get('/account', function () {
    return Inertia::render('Site/Account/Account');
})->name('account');

Route::get('/', function () {
    return Inertia::render('Site/Home/Home');
})->name('index');

Route::get('/checkout', function () {
    return Inertia::render('Site/Checkout/Checkout');
})->name('checkout');

require 'admin/admin_web.php';
require 'raffle/raffle_web.php';
