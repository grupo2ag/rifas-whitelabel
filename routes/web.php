<?php

use App\Http\Controllers\TesteController;
use App\Http\Middleware\LevelMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\RaffleController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Seller\DashboardController;
use Inertia\Inertia;

if(config('app.env') === 'local'){
    Route::get('/teste', [TesteController::class, 'index']);
}

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(LevelMiddleware::class)->group(function (){

    /* ROTAS AUTENTICADAS AQUI */
    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])->group(function () {
        Route::get('/dashboard',[DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('/raffle')->name('raffle.')->group(function () {
            Route::get('/',[SellerController::class, 'index'])->name('index');
            Route::get('/view/{id}',[SellerController::class, 'view'])->name('raffleView');
            Route::get('/created',[SellerController::class, 'created'])->name('rafflecreated');
        });
    });


    /* ROTAS NAO AUTENTICADAS AQUI*/
    Route::get('/account', function () {
        return Inertia::render('Site/Account/Account');
    })->name('account');

    Route::get('/',[HomeController::class, 'index'])->name('index');
    Route::get('/raffle',[RaffleController::class, 'index'])->name('raffle');
    Route::get('/pay',[RaffleController::class, 'pay'])->name('pay');
    Route::get('/verify/{phone}', [RaffleController::class, 'verify'])->name('verify');
    Route::post('/purchase', [RaffleController::class, 'purchase'])->name('purchase');
});

require 'admin/admin_web.php';

