<?php

use App\Http\Controllers\Admin\DashboardController;
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

        Route::get(
            '/raffles/index',
            function () {
                return Inertia::render('Seller/Raffle/RaffleIndex');
            }
        )->name('raffleIndex');

        Route::get(
            '/raffles/view',
            function () {
                return Inertia::render('Seller/Raffle/RaffleView');
            }
        )->name('raffleView');


        /* ROTAS NAO AUTENTICADAS AQUI*/

    });
