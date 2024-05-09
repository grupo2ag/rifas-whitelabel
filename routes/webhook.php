<?php

use Illuminate\Support\Facades\Route;

Route::prefix('/webhook')->group(function () {
    Route::webhooks('pix_payment', 'default', 'post');
});

