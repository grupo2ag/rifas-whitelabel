<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Site\RaffleController;
use App\Http\Middleware\LevelAdminMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::prefix('/super')
    ->middleware(LevelAdminMiddleware::class)
    ->group(function () {
        /* ROTAS AUTENTICADAS ADMIN AQUI */
        Route::middleware([
            'auth:sanctum',
            config('jetstream.auth_session'),
            'verified'
        ])->group(function () {
            Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        });

        Route::prefix('/raffles')->name('raffles.')->group(function () {
            Route::get(
                '/index',
                // function () {
                //     return Inertia::render('Seller/Raffle/RaffleIndex');
                // }
                [RaffleController::class, 'index']
            )->name('raffleIndex');

            Route::get(
                '/view/{id}',
                // function () {
                //     return Inertia::render('Seller/Raffle/RaffleView');
                // }
                [RaffleController::class, 'view']
            )->name('raffleView');
        });



        /* ROTAS NAO AUTENTICADAS AQUI*/

    });
