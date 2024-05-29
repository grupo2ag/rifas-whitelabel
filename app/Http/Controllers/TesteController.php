<?php

namespace App\Http\Controllers;

use App\Events\PixManual;
use App\Events\PixPayment;
use App\Libraries\Pixcred;
use App\Models\Customer;
use App\Models\Participant;
use App\Models\Raffle;
use App\Models\RafflePromotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\SimpleExcel\SimpleExcelWriter;

class TesteController extends Controller
{
    public function index(Request $request)
    {

        //Event::dispatch(new PixPayment('5bf76e86-4361-4bd1-8b2b-997798eb6a28'));
        //dd(numbers_premium(25, 1, ['00001', '00002']));
        //$resp = numbers_devolution(1, 5);
        //dd($resp);
        //Event::dispatch(new PixPayment('1234'));
        //dd('ok');
        //dd(numbers_generate(100000));
        //$request = new Request();
        //$request->merge(["raffle_id"=>1]);
        //dd($this->simulacao_compra($request));
        //dd($request->session());

        /*$pix_data = [
            "value" => 2565,
            "payer_name" => "John Doe",
            "payer_doc" => "62799354505",
            "expiration_time" => 86400,
            "description" => "deposit",
            "url_notify" => "https://webhook.site/61e7d93f-c2a4-4f8f-aa25-25466cdb8a14",
            "order_id" => UUID::uuid4()
        ];
        $esse = pixcred_generate(1, $pix_data);
        dd($esse);
        $teste = new Pixcred(['raffle_id' => 1]);
        //dd($teste);
        $result = $teste->pix_generate();
        $aqui = QrCode::size(250)->generate($result['pix_link']);*/

       /* $registration_data = [
            'name' => 'Sebastião Barbosa Silva',
            'phone' => '55 (53) 91831-8081'
        ];
        dd(numbers_reserve(1, 2, 1, $registration_data, false));*/
        //dd(numbers_available(1));
    }

    public function numbers($id)
    {
        $user = auth()->user();

        $raffle = $user->raffles()->ofId($id)->first();

        $paid = $raffle->participants()->where('participants.raffle_id', $id)
            ->where('participants.paid', '>', 0)
            ->groupBy('participants.raffle_id', 'participants.id')
            ->get([DB::raw("string_agg(participants.numbers, ',') as numbers"), 'participants.name', 'participants.phone']);

        //$reserved = Participant::where('raffle_id', $id)->where('reserved', '>', 0)->groupBy('raffle_id')->get(DB::raw("string_agg(numbers, ',') as numbers"), 'id');

        $part = [];
        foreach ($paid as $item){
            $array_numbers = explode(',', $item->numbers);
            foreach ($array_numbers as $number){
                $part[(int)$number] = [
                    'Numero' => $number,
                    'Nome' => $item->name,
                    'Telefone' => hideString($item->phone, 10, 3),
                    'Estado' => getDDDState($item->phone)
                ];
            }
        }
        sort($part);

        $arqName = Str::slug($raffle->title).'.csv';

        $writer = SimpleExcelWriter::streamDownload($arqName);

        $lazy = collect($part);

        $i = 0;
        foreach ($lazy->lazy() as $item)
        {
            $writer->addRow($item);

            if ($i % 1000 === 0) {
                flush(); // Flush the buffer every 1000 rows
            }
            $i++;
        }
        $writer->toBrowser();
    }

    public function simulacao_compra(Request $request)
    {

        $rifa = Raffle::join('users', 'users.id', 'raffles.user_id')
                        ->join('user_configurations', 'users.id', 'user_configurations.user_id')
                        ->where('raffles.id', $request->raffle_id)
                        ->first(['raffles.type', 'raffles.numbers', 'user_configurations.*']);
        if(empty($rifa)) return response()->json(['error' => true, 'message' => 'Ação não encontrada.'], 403);
        if(empty($rifa->numbers)) return response()->json(['error' => true, 'message' => 'Todos numeros vendidos.'], 403);

        $validate['name'] = 'required|string|min:2|max:255';
        $validate['phone'] = 'required|string|min:10|max:20';
        if($rifa->type == 'manual') $validate['number'] = 'required|array';
        else $validate['number'] = 'array';

        if($rifa->register_cpf) $validate['cpf'] = 'required|cpf';
        if($rifa->register_email) $validate['email'] = 'required|email';

        $validator = Validator::make($request->all(), $validate);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()], 403);
        }

        $customer = Customer::where('phone', $request->phone)->first();
        if(empty($customer)){
            $customer = Customer::create([
                'name' => Str::upper($request->name),
                'phone' => $request->phone
            ]);
        }

        return response()->json(['']);

    }
}
