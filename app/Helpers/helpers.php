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
     * @param int $raffleId - codigo da rifa
     * @param int $qttNumbers - quantidade de numeros reservados/comprados
     * @param int $customerId - codigo do customer
     * @param bool $automatic - compra automatica ou manual
     * @return array
     */
    function numbers_reserve(int $raffleId, int $qttNumbers, int $customerId, array $registration_data, bool $paid = false,  array $numbers = []): array
    {

        $rifa = Raffle::find($raffleId);

        $disponiveis = explode(",", $rifa->numbers); //pega os numeros disponiveis da rifa

        if(empty($registration_data['name']) || empty($registration_data['phone'])) {
            return ['errors' => true, 'message' => 'Informe corretamente o nome e telefone.'];
        }

        //valida os disponiveis com a quantidade solicitada
        if(count($disponiveis) == 0){
            $texto = $rifa->type == 'automatico' ? 'vendidos' : 'vendidos/reservados';
            return ['errors' => true, 'message' => 'Todos '.$texto];
        }
        if (count($disponiveis) < $qttNumbers) {
            return ['errors' => true, 'message' => 'Quantidade indisponível para a rifa selecionada. A quantidade disponível é: ' . count($disponiveis)];
        }

        $resutlNumbers = []; //array retorno numeros aleatorios ou manuais

        if(!empty($numbers)){ //se for manual envia os numeros em um array
            $intersect = array_intersect($numbers, $disponiveis); //verifica se estao disponiveis
            $diff = array_diff($numbers, $intersect); //verifica se estao disponiveis

            if(!empty($diff)){
                $texto = 'O numero está indisponível: '.implode(',', $diff);
                if(count($diff) > 1) $texto = 'Os numeros estão indisponíveis: '.implode(',', $diff);

                return ['errors' => true, 'message' => $texto];
            }

            sort($numbers); //organiza os numeros
            $selecionados = $numbers;

            foreach ($selecionados as $resultNumber) { //retira os numeros do array da rifa
                $resutlNumbers[] = $resultNumber;
                $idx = array_search($resultNumber, $disponiveis);
                unset($disponiveis[$idx]);
            }
        }else{ //numeros aleatorios
            shuffle($disponiveis);
            $selecionados = array_slice($disponiveis, 0, $qttNumbers); //pega a quantidade aleatoria

            foreach ($selecionados as $key => $resultNumber) { //retira os numeros do array da rifa
                $resutlNumbers[] = $resultNumber;
                unset($disponiveis[$key]);
            }
        }

        sort($disponiveis); //organiza os arrays
        sort($resutlNumbers); //organiza os arrays

        $updateNumbers = implode(',', $disponiveis);  //transforma o array em string
        $updateReservedNumbers = implode(',', $resutlNumbers); //transforma o array em string

        DB::beginTransaction(); //inicia a transaction no banco
        try {
            Raffle::where('id', $raffleId)->update(['numbers' => $updateNumbers]); //atualiza a rifa com os novos numeros disponiveis

            //pega o total
            $amount = $rifa->price * $qttNumbers;
            $totalNotDiscount = 0;
            $discount = 0;

            //Verifica se tem promocao
            $promotion_id = null;
            $promotion = raffle_promotion($raffleId, $qttNumbers);
            if(!empty($promotion)){
                $totalNotDiscount = $amount;
                $discount = $promotion['discount'];
                $amount = $promotion['total'];
                $promotion_id = $promotion['id'];
            }

            $expired = !empty($rifa->pix_expired) ? $rifa->pix_expired : 5;

            Participant::create([
                'name' => $registration_data['name'],
                'phone'=> $registration_data['phone'],
                'email' => !empty($registration_data['email']) ? $registration_data['email'] : null,
                'document' => !empty($registration_data['cpf']) ? $registration_data['cpf'] : null,
                'amount' => $amount,
                'numbers' => $updateReservedNumbers,
                'paid' => $paid ? count($resutlNumbers) : 0,
                'reserved' => $paid ? 0 : count($resutlNumbers),
                'customer_id' => $customerId,
                'raffle_id' => $raffleId,
                'raffle_promotion_id' => $promotion_id,
                'expired_at' => Carbon::now()->addMinutes($expired)
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
