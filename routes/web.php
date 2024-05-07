<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

if(config('app.env') === 'local'){
    Route::get('/teste', [\App\Http\Controllers\TesteController::class, 'index']);
}


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
       return (new DashboardController())->index();
        // return Inertia::render('Panel/User/Dashboard');
    })->name('dashboard');
    Route::get('/campaign', function () {
        return Inertia::render('Panel/User/Campaign');
    })->name('campaign');
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


