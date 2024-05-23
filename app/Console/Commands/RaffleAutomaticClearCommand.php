<?php

namespace App\Console\Commands;

use App\Models\Charge;
use Illuminate\Console\Command;

class RaffleAutomaticClearCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'automatic:release';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Liberar numeros das rifas presos por reservas nao pagas do tipo automatico';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $exclui = Charge::where('expired', '<', now())
            ->leftJoin('charge_paids', 'charge_paids.charge_id', 'charges.id')
            ->join('participants', 'participants.id', 'charges.participant_id')
            ->join('raffles', 'raffles.id', 'participants.raffle_id')
            ->where('participants.paid', 0)
            ->where('raffles.type', 'automatico')
            ->whereNull('charge_paids.id')
            ->get(['participants.raffle_id', 'participants.id']);

        if($exclui->isNotEmpty()){
            foreach ($exclui as $item){
                $cancela = numbers_devolution($item->raffle_id, $item->id);
                if(!$cancela)  setLogErros('RaffleAutomaticClear->cancela', [$item, $cancela]);
            }
        }
    }
}
