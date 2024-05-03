<?php

use App\Models\Customer;
use App\Models\Participant;
use App\Models\Raffle;
use App\Models\RafflePromotion;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;

if(!function_exists('numbers_generate')) {
    function numbers_generate(int $quantity)
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
    function numbers_available(int $raffleId)
    {
        $rifa = Raffle::select('numbers')->find($raffleId);

        $numbersRifa = explode(",", $rifa->numbers);

        return $numbersRifa;
    }
}

if(!function_exists('numbers_reserve')) {
    /**
     * @param int $raffleId - dodigo da rifa
     * @param int $qttNumbers - quantidade de numeros reservados/comprados
     * @param int $customerId - codigo do customer
     * @param bool $automatic - compra automatica ou manual
     * @return array
     */
    function numbers_reserve(int $raffleId, int $qttNumbers, int $customerId, bool $paid = false,  array $numbers = []): array
    {

        $rifa = Raffle::find($raffleId);

        $disponiveis = explode(",", $rifa->numbers);

        if(count($disponiveis) == 0){
            $texto = $rifa->type == 'automatico' ? 'vendidos' : 'vendidos/reservados';
            return ['errors' => true, 'message' => 'Todos '.$texto];
        }
        if (count($disponiveis) < $qttNumbers) {
            return ['errors' => true, 'message' => 'Quantidade indisponível para a rifa selecionada. A quantidade disponível é: ' . count($disponiveis)];
        }

        $resutlNumbers = [];

        if(!empty($numbers)){
            $intersect = array_intersect($numbers, $disponiveis);
            $diff = array_diff($numbers, $intersect);

            if(!empty($diff)){
                $texto = 'O numero está indisponível: '.explode(',', $diff);
                if(count($diff) > 1) $texto = 'Os numeros estão indisponíveis: '.explode(',', $diff);

                return ['errors' => true, 'message' => $texto];
            }

            sort($numbers);
            $selecionados = $numbers;

            foreach ($selecionados as $resultNumber) {
                $resutlNumbers[] = $resultNumber;
                $idx = array_search($resultNumber, $disponiveis);
                unset($disponiveis[$idx]);
            }
        }else{
            shuffle($disponiveis);
            $selecionados = array_slice($disponiveis, 0, $qttNumbers);

            foreach ($selecionados as $key => $resultNumber) {
                $resutlNumbers[] = $resultNumber;
                unset($disponiveis[$key]);
            }
        }

        sort($disponiveis);
        sort($resutlNumbers);

        $updateNumbers = implode(',', $disponiveis);
        $updateReservedNumbers = implode(',', $resutlNumbers);
        DB::beginTransaction();
        try {
            Raffle::where('id', $raffleId)->update(['numbers' => $updateNumbers]);
            $customer = Customer::where('id', $customerId)->first();

            $amount = $rifa->price * $qttNumbers;
            $totalNotDiscount = 0;
            $discount = 0;

            $promotion_id = null;
            $promotion = raffle_promotion($raffleId, $qttNumbers);
            if(!empty($promotion)){
                $totalNotDiscount = $amount;
                $discount = $promotion['discount'];
                $amount = $promotion['total'];
                $promotion_id = $promotion['id'];
            }

            Participant::create([
                'name' => $customer->name,
                'phone'=> $customer->phone,
                'email' => $customer->email,
                'document' => $customer->cpf,
                'amount' => $amount,
                'numbers' => $updateReservedNumbers,
                'paid' => $paid ? count($resutlNumbers) : 0,
                'reserved' => $paid ? 0 : count($resutlNumbers),
                'customer_id' => $customerId,
                'raffle_id' => $raffleId,
                'raffle_promotion_id' => $promotion_id
            ]);

            DB::commit();
        }catch (QueryException $e){
            return ['errors' => true, 'message' => 'Problema ao efetuar reserva, verifique seus numeros e tente novamente.'];
            DB::rollBack();
        }

        return ['errors' => false, 'numbers' => $resutlNumbers, 'amount' => $amount, 'totalNotDiscount' => $totalNotDiscount, 'discount' => $discount];
    }
}

if(!function_exists('raffle_promotion')) {
    function raffle_promotion(int $raffleId, int $qttNumbers)
    {
        $rifapromo = RafflePromotion::where('raffle_id', $raffleId)->where('quantity_numbers', '<=', $qttNumbers)->orderBy('quantity_numbers', 'DESC')->first();

        if(!empty($rifapromo)){
            $discount = $rifapromo->discount;
            $amount = $rifapromo->amount;
            $total = $amount * $qttNumbers;

            return ['id' => $rifapromo->id, 'discount' => $discount, 'amount' => $amount, 'total' => $total];
        }

        return false;
    }
}

if (!function_exists('luminosity')) {
    function luminosity($hex)
    {
        if (!empty($hex)) {

            $rgb = explode(' ', $hex);

            $r = $rgb[0];
            $g = $rgb[1];
            $b = $rgb[2];

            $value = ($r * 299 + $g * 587 + $b * 114) / 1000;

            return $value > 150 ? '0 0 0' : '255 255 255';
        }

        return 0;
    }
}
