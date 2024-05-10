<?php

return [
    App\Providers\AppServiceProvider::class,
    App\Providers\FortifyServiceProvider::class,
    App\Providers\JetstreamServiceProvider::class,
    config('app.debug') ? Barryvdh\Debugbar\ServiceProvider::class : null,
];
