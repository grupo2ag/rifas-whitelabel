<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use ShiftOneLabs\LaravelSqsFifoQueue\Bus\SqsFifoQueueable;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SqsFifoQueueable, SerializesModels;

    private $dados;

    public function __construct($params)
    {
        $this->dados = $params;
    }

    //public $tries = 3;

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send(
            new \App\Mail\SendMail($this->dados)
        );
    }
}
