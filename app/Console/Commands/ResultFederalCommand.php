<?php

namespace App\Console\Commands;

use App\Jobs\ResultFederal;
use Illuminate\Console\Command;

class ResultFederalCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'result:federal';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pega o resultado da loterial federal mais atual';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        ResultFederal::dispatch();
    }
}
