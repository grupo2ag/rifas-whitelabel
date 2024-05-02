<?php

use App\Models\Participant;
use App\Models\Raffle;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

if(!function_exists('numbers_generate')) {
    function numbers_generate($quantity)
    {
        $numbers = [];
        $left_zero = strlen($quantity) - 1;

        for ($i = 0; $i < $quantity; $i++) {
            $arr = str_pad($i, $left_zero,  '0', STR_PAD_LEFT);
            array_push( $numbers, $arr);
        }

        return implode(",", $numbers);
    }
}

if(!function_exists('numbers_available')) {
    function numbers_available($raffleId){
        $rifa = Raffle::select('numbers')->find($raffleId);

        $numbersRifa = explode(",", $rifa->numbers);

        return $numbersRifa;
    }
}

if(!function_exists('numbers_reserve')) {
    function numbers_reserve($raffleId, $qttNumbers, $customerId, $reserved = false){

        $disponiveis = numbers_available($raffleId);

        if (count($disponiveis) < $qttNumbers) {
            return json_encode(['errors' => true, 'message' => 'Quantidade indisponível para a rifa selecionada. A quantidade disponível é: ' . count($disponiveis)]);
        }

        shuffle($disponiveis);

        $selecionados = array_slice($disponiveis, 0, $qttNumbers);

        $resutlNumbers = [];
        foreach ($selecionados as $key => $resultNumber) {
            $resutlNumbers[] = $resultNumber;
            unset($disponiveis[$key]);
        }

        sort($disponiveis);
        sort($resutlNumbers);

        $updateNumbers = implode(',', $disponiveis);
        DB::beginTransaction();
        //customer já vir cadastrado só inserir o participant number
        try {
            Raffle::where('id', $raffleId)->update(['numbers' => $updateNumbers]);
            Participant::create();

            DB::commit();
        }catch (QueryException $e){
            DB::rollBack();
        }

        return ['errors' => false, 'reserved' => $resutlNumbers];
    }
}
