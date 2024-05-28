<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use App\Models\AffiliateRaffle;
use App\Models\Raffle;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class AffiliateController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $affiliates = $user->affiliate()->paginate();

        return Inertia::render('Seller/Affiliate/AffiliateIndex', ['data' => $affiliates]);
    }

    public function created()
    {
        $user = auth()->user();
        $raffles = Raffle::activateRaffles()->userID($user->id)->get();
        return Inertia::render('Seller/Affiliate/AffiliateCreated', ['raffles' => $raffles]);
    }

    public function store(Request $request)
    {
        $userId = auth()->user()->id;

        $validator = Validator::make($request->all(), [
            'name' => 'required | string | max:80',
            'description' => 'string | max:100',
            'phone' => 'required',
            'email' => 'required',
            'document' => 'required',
            'pixKey' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()], 403);
        }

        try {
            $affiliate = Affiliate::create([
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'document' => $request->document,
                'pix_key' => $request->pixKey,
                'user_id' => $userId
             ]);

             if(count($request->raffles) > 0) {
                 foreach ($request->raffles as $vinculation) {
                   if($vinculation['raffleId'] && $vinculation['link'] && $vinculation['type']) {

                    AffiliateRaffle::create([
                        'affiliate_id' => (integer)$affiliate->id,
                        'raffle_id' => (integer)$vinculation['raffleId'],
                        'actived' => (integer)1,
                        'type' => (string)$vinculation['type'],
                        'value' => (integer)bcmul($vinculation['value'], 100),
                        'link' => (string)$vinculation['link'],
                    ]);

                   }
                }
            }

             return response()->json([
                'message' => 'Afiliado adicionado com sucesso!',
                'data' => $affiliate
            ], 200);
        } catch (QueryException $e) {
            setLogErros('AffiliateController', $e->getMessage(), $request->all());
            DB::rollBack();
            return response()->json(['message' => 'Problema ao inserir afiliado, verifique os campos!'], 403);
        }

    }
}
