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

// Route::middleware(LevelMiddleware::class)->group(function (){

//     Route::prefix('/campaign')->name('campaign.')->group(function () {
//         Route::get('/index', function () {
//             return Inertia::render('Panel/User/Campaign/Campaign');
//         })->name('index');

//         Route::get('/create', function () {
//             return Inertia::render('Panel/User/Campaign/CampaignCreate');
//         })->name('create');
//     });
// });

    /* ROTAS NAO AUTENTICADAS AQUI*/
    Route::get('/account', function () {
        return Inertia::render('Site/Account/Account');
    })->name('account');

   /* Route::get('/', function () {
       return Inertia::render('Site/Home/Home');
    })->name('index');*/
    require 'admin/admin_web.php';

    Route::get('/',[HomeController::class, 'index'])->name('index');
   Route::get('/raffle',[RaffleController::class, 'index'])->name('raffle');
    Route::get('/pay/{url}',[RaffleController::class, 'pay'])->name('pay');

    Route::get('/verify/{phone}', [RaffleController::class, 'verify'])->name('verify');
    Route::post('/purchase', [RaffleController::class, 'purchase'])->name('purchase');

Route::get('/account', function () {
    return Inertia::render('Site/Account/Account');
})->name('account');

Route::get('/', function () {
    return Inertia::render('Site/Home/Home');
})->name('index');

Route::get('/checkout', function () {
    return Inertia::render('Site/Checkout/Checkout');
})->name('checkout');

