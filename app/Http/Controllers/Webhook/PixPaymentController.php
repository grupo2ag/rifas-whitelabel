<?php

namespace App\Http\Controllers\Webhook;

use App\Events\PixPayment;
use App\Http\Controllers\Controller;
use App\Jobs\SendMail;
use App\Models\Charge;
use App\Models\ChargePaid;
use App\Models\Participant;
use Carbon\Carbon;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;

class PixPaymentController extends Controller
{
    public function create($response)
    {
        if (!empty($response['order_id'])) {

            $order_id = $response['order_id'];

            $charge = Charge::leftJoin('charge_paids', 'charge_paids.charge_id', '=', 'charges.id')
                ->where('charges.pix_id', $order_id)
                ->whereNull('charge_paids.id')
                ->first(['charges.*', 'charge_paids.id as paid_id']);

            if (!empty($charge->pix_id)) { //ainda nao foi pago
                $agora = Carbon::now()->toDateTimeString();

                $participant = Participant::join('charges', 'charges.participant_id', '=', 'participants.id')
                    ->join('raffles', 'raffles.id', '=', 'participants.raffle_id')
                    ->join('customers', 'customers.id', '=', 'participants.customer_id')
                    ->where('charges.pix_id', $order_id)
                    ->withTrashed()
                    ->first(['participants.*', 'raffles.title as raffle_title', 'customers.name as customer_name',
                             'customers.name as customer_name', 'customers.email as customer_email',
                             'customers.cpf as customer_cpf', 'customers.phone as customer_phone']);

                $expire = Carbon::parse($participant->expired_at)->lte($agora);

                if(!empty($participant->deleted_at) || $expire){
                    $cancela = numbers_devolution($participant->raffle_id, $participant->id);
                    if(!$cancela)  setLogErros('PixPayment->cancela', [$participant, $charge, $response]);
                    return true;
                }

                DB::beginTransaction();
                try {
                    $qtdeTitulos = $participant->reserved;
                    $updt = Participant::where('id', $participant->id)->update(['paid' => $qtdeTitulos, 'reserved' => 0]);

                    if(!$updt){
                        setLogErros('WEBHOOK->update-participant', $participant, [$updt, $response, $charge]);
                        DB::rollBack();
                        return false;
                    }

                    $chargePaid = [
                        'e2e' => $response['endToEndId'],
                        'paied_date' => $response['payment_date'],
                        'charge_id' => $charge->id,
                        'json_response' => json_encode($response),
                    ];
                    $cp = ChargePaid::create($chargePaid);

                    Event::dispatch(new PixPayment($order_id));

                    if(!empty($participant->customer_email)){
                        //ENVIAR EMAIL
                        $emailSend = [
                            'assunto' => 'Seus numeros da sorte',
                            'conteudo' => !empty($participant->raffle_title) ? $participant->raffle_title : '',
                            'email' => !empty($participant->customer_email) ? $participant->customer_email : '',
                            'nome' => !empty($participant->customer_name)  ? $participant->customer_name : '',
                            'phone' => !empty($participant->customer_phone)  ? $participant->customer_phone : '',
                            'documento' => !empty($participant->customer_cpf)  ? $participant->customer_cpf : '',
                            'numbers' => $participant->numbers,
                            'mail' => 'numbers'];
                        SendMail::dispatch($emailSend)->onQueue('emails');
                    }

                    DB::commit();
                }catch (QueryException $e){
                    setLogErros('WEBHOOK->catch', $e->getMessage(), $response);
                    DB::rollBack();
                    return false;
                }
            }else return true;
        }
        return true;
    }
}
