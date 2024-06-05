<?php

namespace App\Jobs;

use App\Models\ResultsFederal;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use ShiftOneLabs\LaravelSqsFifoQueue\Bus\SqsFifoQueueable;

class ResultFederal implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SqsFifoQueueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = Http::get('https://loteriascaixa-api.herokuapp.com/api/federal/latest'); //TIRAR O LATEST PARA INSERIR TODOS RESULTADOS

        $statusCode = 0;

        if(!empty($response->status())) $statusCode = $response->status();
        //dd($response->status(), $response->json());
        if ($statusCode === 200 || $statusCode === 201 || $statusCode === 202) {
            $responseBody = $response->json();

            if(!empty($responseBody) && is_array($responseBody)){

                //foreach ($responseBody as $value) {
                    $value = $responseBody; //QUANDO TIRA O FOREACH DA PRIMEIRA INSERCAO DEIXAR ASSIM
                    $data = Carbon::createFromFormat('d/m/Y', $value['data'])->format('Y-m-d');
                    $insert = [
                        'date'   => $data,
                        'local'   => $value['local'],
                        'concurso'   => $value['concurso'],
                        'results'   => implode(',', $value['dezenasOrdemSorteio']),
                        'r1'   => $value['dezenasOrdemSorteio'][0],
                        'r2'   => $value['dezenasOrdemSorteio'][1],
                        'r3'   => $value['dezenasOrdemSorteio'][2],
                        'r4'   => $value['dezenasOrdemSorteio'][3],
                        'r5'   => $value['dezenasOrdemSorteio'][4]
                    ];

                    if(!empty($data)){
                        ResultsFederal::updateOrCreate(
                            [
                                'date'   => $data
                            ],
                            $insert
                        );
                    }

                //}
            }

            return;
            //return $responseBody;
        }
    }
}
