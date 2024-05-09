<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Middleware\LevelAdminMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;


Route::prefix('/super')
    ->middleware( LevelAdminMiddleware::class)
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

    Route::prefix('/campaign')->name('campaign.')->group(function () {
        Route::get('/index', function () {
            return Inertia::render('Panel/User/Campaign/Campaign');
        })->name('index');

        Route::get('/create', function () {
            return Inertia::render('Panel/User/Campaign/CampaignCreate');
        })->name('create');
    });

    /* ROTAS NAO AUTENTICADAS AQUI*/

});
