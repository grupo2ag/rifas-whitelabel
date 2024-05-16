<?php

use App\Http\Controllers\TesteController;
use App\Http\Middleware\LevelMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\RaffleController;
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

/* Route::middleware(LevelMiddleware::class)->group(function (){

     Route::prefix('/campaign')->name('campaign.')->group(function () {
         Route::get('/index', function () {
             return Inertia::render('Panel/User/Campaign/Campaign');
         })->name('index');

         Route::get('/create', function () {
             return Inertia::render('Panel/User/Campaign/CampaignCreate');
         })->name('create');
     });


 });*/



Route::middleware(LevelMiddleware::class)->group(function (){

    /* ROTAS AUTENTICADAS AQUI */
    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])->group(function () {
        Route::get('/dashboard', function () {
            //return auth()->user()->level === 1 ? Inertia::render('Dashboard') : Redirect::route('admin.dashboard');
            return Inertia::render('Dashboard');
        })->name('dashboard');


        Route::get('/raffles', function () {
            //return auth()->user()->level === 1 ? Inertia::render('Dashboard') : Redirect::route('admin.dashboard');
            return Inertia::render('Seller/Raffle/RaffleIndex');
        })->name('raffles');

        Route::get('/raffles/view', function () {
            //return auth()->user()->level === 1 ? Inertia::render('Dashboard') : Redirect::route('admin.dashboard');
            return Inertia::render('Seller/Raffle/RaffleView');
        })->name('rafflesc');

        Route::get('/raffle/create', function () {
            //return auth()->user()->level === 1 ? Inertia::render('Dashboard') : Redirect::route('admin.dashboard');
            return Inertia::render('Seller/Raffle/RaffleCreate');
        })->name('rafflecreated');
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

