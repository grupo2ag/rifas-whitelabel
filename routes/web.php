<?php

use App\Http\Controllers\TesteController;
use App\Http\Middleware\LevelMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\RaffleController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Seller\DashboardController;
use App\Http\Controllers\Seller\GatewayController;
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
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('/raffles')->name('raffles.')->group(function () {
            Route::get('/', [SellerController::class, 'index'])->name('raffleIndex');
            Route::get('/view/{id}', [SellerController::class, 'view'])->name('raffleView');
            Route::get('/created', [SellerController::class, 'created'])->name('raffleCreated');
            Route::post('/store', [SellerController::class, 'store'])->name('raffleStore');
            Route::post('/updated/{id}',[SellerController::class, 'updated'])->name('raffleUpdated');
            Route::get('/participants',[SellerController::class, 'getParticipants'])->name('raffleParticipants');
        });

        Route::get('/paymentMethods', [GatewayController::class, 'index'])->name('paymentMethods');
    });
});

/* ROTAS NAO AUTENTICADAS AQUI*/

Route::get('/', [HomeController::class, 'index'])->name('index');
Route::get('/termos-de-uso', [HomeController::class, 'termsUse'])->name('termsUse');
Route::get('/pay/{order}', [RaffleController::class, 'pay'])->name('pay');
Route::get('/reserved/{participant}', [RaffleController::class, 'reserved'])->name('reserved');
Route::get('/verify/{phone}', [RaffleController::class, 'verify'])->name('verify');
Route::get('/generate/{particpant}', [RaffleController::class, 'generate'])->name('generate');
Route::get('/openpay/{particpant}', [RaffleController::class, 'openPay'])->name('openpay');
Route::get('/reserved_verify/{link}', [RaffleController::class, 'reservedVerify'])->name('reservedVerify');
Route::post('/purchase', [RaffleController::class, 'purchase'])->name('purchase');
Route::get('/account/{cpf}', [RaffleController::class, 'mybillets'])->name('account');

Route::get('/{url}/{affiliate?}', [RaffleController::class, 'index'])->name('raffle');

require 'admin/admin_web.php';

