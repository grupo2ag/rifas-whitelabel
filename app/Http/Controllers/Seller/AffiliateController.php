<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use App\Models\Participant;
use App\Models\AffiliateRaffle;
use App\Models\Raffle;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class AffiliateController extends Controller
{
    public function index($affiliateId = null)
    {
        $user = auth()->user();

        $gateway = $user->gatewayConfigurations()->first();

        if(empty($gateway->token) || empty($gateway->login)){
            return redirect()->route('paymentMethods')->with('message', 'Primeiro passo configure o Gateway');
        }

        if(!empty($affiliateId)){
            $affiliate = $user->affiliate()->where('affiliates.id', $affiliateId)->first();

            return Inertia::render('Seller/Affiliate/AffiliateDashboard', ['data' => $affiliate]);
        }

        if(!empty($affiliate)){
            dd($affiliate);
        }

        $affiliates = $user->affiliate()->orderBy('id', 'asc')->paginate();

        return Inertia::render('Seller/Affiliate/AffiliateIndex', ['data' => $affiliates]);
    }

    public function commissions(Request $request)
    {
        $request->validate([
            'query' => 'max:255',
            'page' => 'integer|string',
            'idAffiliate' => 'required|integer|string'
        ]);
        //dd($request->all());
        $winnings = Participant::join('raffles', 'raffles.id', 'participants.raffle_id')
            ->join('affiliate_raffles', 'affiliate_raffles.raffle_id', 'raffles.id')
            ->where('participants.paid', '>', 0)
            ->where('participants.affiliate_id', $request->idAffiliate)
            ->select('raffles.id',
                'raffles.status',
                'raffles.title',
                'raffles.price',
                'affiliate_raffles.type',
                'affiliate_raffles.value',
                'affiliate_raffles.link',
                DB::raw('SUM(participants.amount) as total,
                                                SUM(participants.paid) as paids,
                                                COUNT(participants.id) as sales'))
            ->groupBy('raffles.id', 'affiliate_raffles.raffle_id', 'affiliate_raffles.affiliate_id')
            ->orderBy('raffles.id', 'DESC')
            ->get();

        //dd($winnings);
        if(!empty($winnings)){
            $retorno = [];
            foreach ($winnings as $item){
                if($item->type === 'percent'){
                    $commission = number_format(($item->total/100)*(($item->value/100)/100), 2);
                    $commission_value = ($item->value/100).'%';
                }else{
                    $commission = $item->paids*($item->value/100);
                    $commission_value = 'R$ '.($item->value/100);
                }
                array_push($retorno, [
                    'raffle' => $item->id,
                    'title' => $item->title,
                    'status' => $item->status,
                    'price' => $item->price,
                    'link' => $item->link,
                    'commission' => $commission,
                    'commission_type' => $item->type,
                    'commission_value' => $commission_value,
                    'sales' => $item->sales,
                    'quotas' => $item->paids,
                    'total' => $item->total
                ]);
            }

            return response()->json($retorno);
        }

        return response()->json(false);
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
            if($request->id) {
                $affiliate = Affiliate::updateOrCreate(
                    [
                        'id' => $request->id
                    ],
                    [
                        'name' => $request->name,
                        'phone' => $request->phone,
                        'email' => $request->email,
                        'document' => $request->document,
                        'pix_key' => $request->pixKey,
                        'user_id' => $userId,
                        'description' => $request->description
                    ]
                );
            }else {
                $affiliate = Affiliate::create([
                    'name' => $request->name,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'document' => $request->document,
                    'pix_key' => $request->pixKey,
                    'user_id' => $userId,
                    'description' => $request->description
                 ]);
            }
             if(count($request->raffles) > 0) {
                 foreach ($request->raffles as $vinculation) {
                   if($vinculation['raffle_id'] && $vinculation['link'] && $vinculation['type']) {

                    if(array_key_exists('affiliate_id', $vinculation)) {
                        AffiliateRaffle::updateOrCreate(
                            [
                                'affiliate_id' => (integer)$vinculation['affiliate_id'],
                                'raffle_id' => (integer)$vinculation['raffle_id']
                            ],
                    [
                                'actived' => (integer)1,
                                'type' => (string)$vinculation['type'],
                                'value' => $vinculation['value'],
                                'link' => (string)$vinculation['link'],
                            ]
                        );
                    }else {
                        AffiliateRaffle::create([
                            'affiliate_id' => (integer)$affiliate->id,
                            'raffle_id' => (integer)$vinculation['raffle_id'],
                            'actived' => (integer)1,
                            'type' => (string)$vinculation['type'],
                            'value' => $vinculation['value'],
                            'link' => (string)$vinculation['link'],
                        ]);
                    }

                   }
                }
            }

             return response()->json([
                'message' => $request->id ? 'Alteração realizada com sucesso' : 'Afiliado adicionado com sucesso!',
                'data' => [$affiliate]
            ], 200);
        } catch (QueryException $e) {
            DB::rollBack();
            setLogErros('AffiliateController', $e->getMessage(), $request->all());
            return response()->json(['message' => 'Problema ao inserir afiliado, verifique os campos!'], 403);
        }
    }

    public function edit($id) {
        $user = auth()->user();
        $raffles = Raffle::activateRaffles()->userID($user->id)->get();
        $affiliate = Affiliate::ofUserId($user->id)->ofId($id)->first();
        $affiliateVinculations = $affiliate->affiliate_raffles()->get();

        $affiliate['vinculations'] = $affiliateVinculations;

        return Inertia::render('Seller/Affiliate/AffiliateCreated', ['raffles' => $raffles, 'affiliate' => $affiliate]);
    }
    public function updated(Request $request) {
        dd($request);
    }
    public function deleteVinculation(Request $request) {
        $validator = Validator::make($request->data, [
            'affiliateId' => 'required | integer | string',
            'raffleId' => 'required | integer | string'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()], 403);
        }

        $user = auth()->user();
        $affiliate = Affiliate::ofUserId($user->id)->ofId($request->data['affiliateId'])->first();
        $affiliateVinculation = $affiliate->affiliate_raffles()->ofRaffleId($request->data['raffleId']);

        if($affiliateVinculation->exists()) {
            $affiliateVinculation->delete();
            return response()->json(['message' => 'Desvinculacao realizada com sucesso!'], 200);
        }
        return response()->json(['message' => 'Falha ao realizar a desvinculacao'], 403);
    }
}
