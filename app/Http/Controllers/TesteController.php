<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Raffle;
use App\Models\RafflePromotion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class TesteController extends Controller
{
    public function index(Request $request)
    {
        //dd(numbers_generate(100000));
        //$request = new Request();
        //$request->merge(["raffle_id"=>1]);
        //dd($this->simulacao_compra($request));
        //dd($request->session());
        $registration_data = [
            'name' => 'Sebastião Barbosa Silva',
            'phone' => '55 (53) 91831-8081'
        ];
        dd(numbers_reserve(1, 2, 1, $registration_data, false, ['00000', '00003']));
        //dd(numbers_available(1));
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
