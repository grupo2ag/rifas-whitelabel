<?php

use App\Http\Controllers\Seller\AffiliateController;
use App\Http\Controllers\TesteController;
use App\Http\Middleware\LevelMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Site\HomeController;
use App\Http\Controllers\Site\RaffleController;
use App\Http\Controllers\Seller\SellerController;
use App\Http\Controllers\Seller\DashboardController;
use App\Http\Controllers\Seller\GatewayController;
use App\Http\Controllers\Seller\UserConfigurationsController;
use Inertia\Inertia;

if(config('app.env') === 'local'){
    Route::get('/testee', [TesteController::class, 'index']);
    Route::get('/compra', [TesteController::class, 'simulacao_compra']);
}

Route::middleware(LevelMiddleware::class)->group(function (){

    /* ROTAS AUTENTICADAS AQUI */
    Route::middleware([
        'auth:sanctum',
        config('jetstream.auth_session'),
        'verified',
    ])->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        Route::prefix('/user')->name('user.')->group(function () {
            Route::put('/store', [UserConfigurationsController::class, 'store'])->name('userStore');
        });

        Route::prefix('/raffles')->name('raffles.')->group(function () {
            Route::get('/', [SellerController::class, 'index'])->name('raffleIndex');
            Route::get('/view/{id}', [SellerController::class, 'view'])->name('raffleView');
            Route::get('/created', [SellerController::class, 'created'])->name('raffleCreated');
            Route::get('/edit/{id}', [SellerController::class, 'edit'])->name('raffleEdit');
            Route::post('/store', [SellerController::class, 'store'])->name('raffleStore');
            Route::post('/update', [SellerController::class, 'update'])->name('raffleUpdate');
            Route::post('/updated/{id}',[SellerController::class, 'updated'])->name('raffleUpdated');
            Route::get('/participants',[SellerController::class, 'getParticipants'])->name('raffleParticipants');
            Route::get('/reserved_canceled/{participant}/{raffle}',[SellerController::class, 'reservedCanceled'])->name('raffleRemoveReserve');
            Route::get('/live/{id}', [SellerController::class, 'live'])->name('raffleLive');
            Route::get('/export/{id}',[SellerController::class, 'export'])->name('raffleExport');
            //Route::get('/sale/{id}/{condition}', [SellerController::class, 'sale'])->name('raffleSale');
            Route::get('/awards/{id}', [SellerController::class, 'awards'])->name('raffleAwards');
            Route::get('/awards/check/{id}', [SellerController::class, 'checkAwards'])->name('raffleCheckAwards');
            Route::get('/award/{raffle}/{number}', [SellerController::class, 'award'])->name('raffleAward');
            Route::get('/awardPart/{raffle}/{award}/{part}/{number}', [SellerController::class, 'awardPart'])->name('raffleAwardPart');
            Route::get('/affiliates/{id}', [SellerController::class, 'affiliates'])->name('raffleAffiliates');
        });

        Route::prefix('/affiliate')->name('affiliate.')->group(function () {
            Route::get('/created', [AffiliateController::class, 'created'])->name('affiliateCreated');
            Route::get('/commissions', [AffiliateController::class, 'commissions'])->name('affiliateCommissions');
            Route::get('/edit/{id}',[AffiliateController::class, 'edit'])->name('affiliateEdit');
            Route::get('/{affiliate?}', [AffiliateController::class, 'index'])->name('affiliateIndex');
            Route::post('/store', [AffiliateController::class, 'store'])->name('affiliateStore');
            Route::post('/updated/{id}',[AffiliateController::class, 'updated'])->name('affiliateUpdated');
            Route::delete('/deleteVinculation',[AffiliateController::class, 'deleteVinculation'])->name('affiliateDeleteVinculation');
        });

        Route::get('/paymentMethods', [GatewayController::class, 'index'])->name('paymentMethods');
        Route::post('/paymentMethodsStore', [GatewayController::class, 'store'])->name('paymentMethods.store');
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

Route::get('/email', [RaffleController::class, 'email'])->name('email');
Route::get('/{url}/{affiliate?}', [RaffleController::class, 'index'])->name('raffle');


require 'admin/admin_web.php';

