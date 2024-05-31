<?php

//use Illuminate\Foundation\Inspiring;
//use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;
use Spatie\WebhookClient\Models\WebhookCall;

/*Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();*/

Schedule::command('model:prune', [
    '--model' => [WebhookCall::class],
])->daily();

Schedule::command('automatic:release')->everyMinute(); //LIBERA NUMEROS DAS RIFAS AUTOMATICAS
Schedule::command('manual:release')->everyMinute(); //LIBERA NUMEROS DAS RIFAS MANUAIS

/*PEGA AUTOMATICO RESULTADO DA FEDERAL*/
Schedule::command('result:federal')->at('20:00')->days([3,6])->withoutOverlapping();
Schedule::command('result:federal')->at('01:00')->days([4,0])->withoutOverlapping();

