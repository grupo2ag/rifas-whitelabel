<?php

use App\Libraries\Pixcred;
use App\Models\Charge;
use App\Models\Customer;
use App\Models\LogError;
use App\Models\Participant;
use App\Models\Raffle;
use App\Models\RafflePromotion;
use Carbon\Carbon;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

if(!function_exists('pixcred_generate')) {

    function pixcred_generate(int $raffleId, array $pix_data)
    {

        $rifa = Raffle::join('gateways', 'gateways.id', '=', 'raffles.gateway_id')
            ->leftJoin('gateway_configurations', 'gateway_configurations.user_id', 'raffles.user_id')
            ->whereRaw('gateway_configurations.gateway_id = gateways.id')
            ->where('raffles.id', $raffleId)
            ->first(['gateway_configurations.*','gateways.*']);

        if(empty($rifa->token) || empty($rifa->login)) {
            setLogErros('Libraries->Pixcred', 'Rifa faltando gateway', $rifa, 'algum dado do gateway vazio', $raffleId );
            return false;
        }

        if(config('app.env') === 'production') $endpoint = $rifa->endpoint_prod;
        else $endpoint = $rifa->endpoint_sandbox;

        $pix = new Pixcred(['token' => $rifa->token, 'endpoint' => $endpoint, 'authtoken' => $rifa->token, 'authlogin' => $rifa->login]);

        $params['value'] = (float)($pix_data['value']/100);
        $params['payer_name'] = $pix_data['payer_name'];
        $params['expiration_time'] = $pix_data['expiration_time'];
        $params['description'] = $pix_data['description'];
        $params['order_id'] = $pix_data['order_id'];

        if(!empty($pix_data['payer_doc'])) $params['payer_doc'] = $pix_data['payer_doc'];

        $generator = $pix->pix_generate($params);

        if(!empty($generator['pix_link'])) {
            $generator['qrCode'] = QrCode::size(250)->generate($generator['pix_link']);

            return $generator;
        }

        return false;
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

        if(!empty($rifa)){
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
                //Raffle::where('id', $raffleId)->update(['numbers' => $updateNumbers]);
                $rifa->numbers = $updateNumbers;//atualiza a rifa com os novos numeros disponiveis
                $rifa->save();

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

                $minutes = !empty($rifa->pix_expired) ? $rifa->pix_expired : 5;
                $expired_part =  Carbon::now()->addMinutes($minutes+Raffle::TOLERANCIA_PAGAMENTO);
                $expired = Carbon::now()->addMinutes($minutes);

                $participant = Participant::create([
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
                    'expired_at' => $expired_part
                ]);

                if(empty($participant->id)){
                    //throw new Exception('Erro geração do pix');
                    setLogErros('HELPERS->numbers_reserve', 'Erro inserir participant', $participant, 'catch', $raffleId);
                    return ['errors' => true, 'message' => 'Problema ao reservar, tente novamente.'];
                    DB::rollBack();
                }

                $expired_time = (int)$minutes*60;
                $pix_data = [
                    "value" => $amount,
                    "payer_name" => $registration_data['name'],
                    "payer_doc" => !empty($registration_data['cpf']) ? $registration_data['cpf'] : null,
                    "expiration_time" => $expired_time,
                    "description" => $rifa->title.'-'.$raffleId,
                    "order_id" => UUID::uuid4(),
                    "participant" => $participant->id
                ];
                $generate = pixcred_generate($raffleId, $pix_data);

                if(!$generate){
                    //throw new Exception('Erro geração do pix');
                    setLogErros('HELPERS->pixcred_generate', 'Erro geração do pix', $pix_data, 'catch', $raffleId);
                    return ['errors' => true, 'message' => 'Problema ao reservar, tente novamente.'];
                    DB::rollBack();
                }

                Charge::create([
                    'pix_id' => $generate['order_id'],
                    'pix_code' => $generate['pix_link'],
                    'amount' => $amount,
                    'json' => json_encode($generate),
                    'expired' => $expired,
                    'participant_id' => $participant->id
                ]);

                DB::commit();
            }catch (QueryException $e){
                setLogErros('HELPERS->numbers_reserve', $e->getMessage(), [$raffleId, $qttNumbers, $customerId, $registration_data, $paid,  $numbers], 'catch', $raffleId);
                return ['errors' => true, 'message' => 'Problema ao efetuar reserva, tente novamente.'];
                DB::rollBack();
            }

            return ['errors' => false, 'numbers' => $resutlNumbers, 'amount' => $amount, 'totalNotDiscount' => $totalNotDiscount, 'discount' => $discount, 'pix' => $generate];
        }

        return ['errors' => true, 'message' => 'Rifa não encontrada.'];
    }
}

if(!function_exists('numbers_premium')) {
    /**
     * @param int $raffleId - codigo da rifa
     * @param int $qttNumbers - quantidade de numeros reservados/comprados
     * @param int $customerId - codigo do customer
     * @param bool $automatic - compra automatica ou manual
     * @return array
     */
    function numbers_premium(int $ParticipantId, ): array
    {

        $rifa = Raffle::find($raffleId);

        if(!empty($rifa)){
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
                //Raffle::where('id', $raffleId)->update(['numbers' => $updateNumbers]);
                $rifa->numbers = $updateNumbers;//atualiza a rifa com os novos numeros disponiveis
                $rifa->save();

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

                $minutes = !empty($rifa->pix_expired) ? $rifa->pix_expired : 5;
                $expired_part =  Carbon::now()->addMinutes($minutes+Raffle::TOLERANCIA_PAGAMENTO);
                $expired = Carbon::now()->addMinutes($minutes);

                $participant = Participant::create([
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
                    'expired_at' => $expired_part
                ]);

                if(empty($participant->id)){
                    //throw new Exception('Erro geração do pix');
                    setLogErros('HELPERS->numbers_reserve', 'Erro inserir participant', $participant, 'catch', $raffleId);
                    return ['errors' => true, 'message' => 'Problema ao reservar, tente novamente.'];
                    DB::rollBack();
                }

                $expired_time = (int)$minutes*60;
                $pix_data = [
                    "value" => $amount,
                    "payer_name" => $registration_data['name'],
                    "payer_doc" => !empty($registration_data['cpf']) ? $registration_data['cpf'] : null,
                    "expiration_time" => $expired_time,
                    "description" => $rifa->title.'-'.$raffleId,
                    "order_id" => UUID::uuid4(),
                    "participant" => $participant->id
                ];
                $generate = pixcred_generate($raffleId, $pix_data);

                if(!$generate){
                    //throw new Exception('Erro geração do pix');
                    setLogErros('HELPERS->pixcred_generate', 'Erro geração do pix', $pix_data, 'catch', $raffleId);
                    return ['errors' => true, 'message' => 'Problema ao reservar, tente novamente.'];
                    DB::rollBack();
                }

                Charge::create([
                    'pix_id' => $generate['order_id'],
                    'pix_code' => $generate['pix_link'],
                    'amount' => $amount,
                    'json' => json_encode($generate),
                    'expired' => $expired,
                    'participant_id' => $participant->id
                ]);

                DB::commit();
            }catch (QueryException $e){
                setLogErros('HELPERS->numbers_reserve', $e->getMessage(), [$raffleId, $qttNumbers, $customerId, $registration_data, $paid,  $numbers], 'catch', $raffleId);
                return ['errors' => true, 'message' => 'Problema ao efetuar reserva, tente novamente.'];
                DB::rollBack();
            }

            return ['errors' => false, 'numbers' => $resutlNumbers, 'amount' => $amount, 'totalNotDiscount' => $totalNotDiscount, 'discount' => $discount, 'pix' => $generate];
        }

        return ['errors' => true, 'message' => 'Rifa não encontrada.'];
    }
}

if(!function_exists('numbers_devolution')) {
    function numbers_devolution(int $raffleId, int $participantId)
    {
        $rifa = Raffle::find($raffleId);
        $participant = Participant::find($participantId);

        if(!empty($participant->id) && !empty($rifa->id)){
            $numbers = explode(',', $participant->numbers);

            $disponiveis = explode(",", $rifa->numbers); //pega os numeros disponiveis da rifa

            $diff = array_diff($numbers, $disponiveis);

            if(!empty($diff)){
                $novosDisponiveis  = array_merge($disponiveis, $diff);
                sort($novosDisponiveis);

                $atualizar = implode(",", $novosDisponiveis);
                DB::beginTransaction();
                try{
                    $rifa->numbers = $atualizar;
                    $rifa->save();

                    $participant->reserved = 0;
                    $participant->paid = 0;
                    $participant->amount = 0;
                    $participant->deleted_at = Carbon::now();
                    $participant->save();

                    DB::commit();
                }catch (QueryException $e){
                    setLogErros('HELPERS->numbers_devolution', $e->getMessage(), [$rifa, $participant]);
                    DB::rollBack();
                    return false;
                }
                return true;
            }
        }
        return false;
    }
}

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

if(!function_exists('setLogErros')) {

    function setLogErros($table, $exception = null, $payload = null, $comment = null, $id_reference = null)
    {
        $log = [
            'users_id' => !empty(inertia()->getShared('siteconfig')->user_id) ? inertia()->getShared('siteconfig')->user_id : null,
            'exception' => json_encode($exception),
            'payload'  => json_encode($payload),
            'table'  => $table,
            'comment'  => $comment,
            'id_reference'  => $id_reference
        ];

        if (LogError::create($log)) return true;

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
