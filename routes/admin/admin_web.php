<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Middleware\LevelAdminMiddleware;
use Illuminate\Support\Facades\Route;

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

        /* ROTAS NAO AUTENTICADAS AQUI*/

    });
