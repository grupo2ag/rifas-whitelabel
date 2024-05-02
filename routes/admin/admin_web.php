<?php

use App\Http\Controllers\Admin\DashboardController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::prefix('/super')
    ->middleware( \App\Http\Middleware\LevelAdminMiddleware::class)
    ->group(function()
{
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
