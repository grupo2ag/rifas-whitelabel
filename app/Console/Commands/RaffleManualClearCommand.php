<?php

namespace App\Console\Commands;

use App\Models\Charge;
use App\Models\Raffle;
use Illuminate\Console\Command;

class RaffleManualClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'manual:release';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Liberar numeros das rifas presos por reservas nao pagas do tipo manual';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $exclui = Raffle::where('expired_at', '<', now()->subMinutes(Raffle::TOLERANCIA_PAGAMENTO))
            ->join('participants', 'participants.raffle_id', 'raffles.id')
            ->where('participants.paid', 0)
            ->where('raffles.type', 'manual')
            ->get(['participants.raffle_id', 'participants.id']);

        if($exclui->isNotEmpty()){
            foreach ($exclui as $item){
                $cancela = numbers_devolution($item->raffle_id, $item->id);
                if(!$cancela)  setLogErros('RaffleManualClear->cancela', [$item, $cancela]);
            }
        }
    }
}
