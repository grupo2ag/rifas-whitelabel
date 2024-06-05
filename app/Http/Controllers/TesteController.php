<?php

namespace App\Http\Controllers;

use App\Events\PixManual;
use App\Events\PixPayment;
use App\Jobs\ResultFederal;
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
        raffle_finaliza(1);
    }

    public function simulacao_compra(Request $request)
    {
        //dd($request);
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
                'phone' => $request->phone,
                'email' => $request->email,
                'cpf' => $request->cpf,
            ]);
        }

        $rand = rand(1, 100);
        $randA = rand(0, 1);

        $registration_data = [
            'name' => $customer->name,
            'phone' => $customer->phone,
            'email' => $customer->email,
            'cpf' => $customer->cpf,
            'affiliate_id' => $randA > 0 ? $randA : null
        ];

        numbers_reserve($request->raffle_id, $rand, $customer->id, $registration_data, true);

        return 1;

    }
}
