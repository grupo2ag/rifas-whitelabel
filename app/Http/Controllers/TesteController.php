<?php

namespace App\Http\Controllers;

use App\Events\PixManual;
use App\Events\PixPayment;
use App\Jobs\ResultFederal;
use App\Jobs\SendMail;
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
        //raffle_finaliza(1);
        /*for($i=0;$i<1000;$i++){
            dd($this->simulacao_compra($request));
        }*/


        $logo = inertia()->getShared('siteconfig')->logo;

        $emailSend = [
            'assunto' => 'Seus numeros da sorte',
            'logo' => config('constants.LOGO_PNG'),
            'conteudo' => 'Rifa do Joao',
            'email' => 'rafael@l8.vc',
            'nome' => 'Rafael',
            'phone' => '12312312312312312',
            'documento' => '132123123123',
            'numbers' => '123,321,333,222,111',
            'thumb' => 'https://s3.amazonaws.com/xas-sorteios-public/raffles/images/2/gallery/4/e28be13e-1e12-43d1-ba00-9a5e2c1a2acb.webp?X-Amz-Content-Sha256=UNSIGNED-PAYLOAD&X-Amz-Algorithm=AWS4-HMAC-SHA256&X-Amz-Credential=AKIASMXPRJKLI6HZ2HWZ%2F20240605%2Fus-east-1%2Fs3%2Faws4_request&X-Amz-Date=20240605T162256Z&X-Amz-SignedHeaders=host&X-Amz-Expires=1800&X-Amz-Signature=7d445edc0ea57874539032e1093e285bd3a006a8764dcf33bdb646a4df59cffd',
            'title' => 'CHEVROLET CRUZE 1.4 TURBO',
            'expected_date' => '28/06/2024',
            'mail' => 'numbers'];
        return view('emails.numbers', ['params' => $emailSend]);
        //SendMail::dispatch($emailSend)->onQueue('emails');
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
