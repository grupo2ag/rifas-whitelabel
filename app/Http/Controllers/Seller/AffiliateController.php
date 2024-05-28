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

        if(!empty($affiliateId)){
            $affiliate = $user->affiliate()->where('affiliates.id', $affiliateId)->first();

            return Inertia::render('Seller/Affiliate/AffiliateDashboard', ['data' => $affiliate]);
        }

        if(!empty($affiliate)){
            dd($affiliate);
        }

        $affiliates = $user->affiliate()->paginate();

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
            DB::rollBack();
            setLogErros('AffiliateController', $e->getMessage(), $request->all());
            return response()->json(['message' => 'Problema ao inserir afiliado, verifique os campos!'], 403);
        }

    }
}
