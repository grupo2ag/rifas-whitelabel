<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use App\Models\Participant;
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

            $ganhos = Participant::join('raffles', 'raffles.id', 'participants.raffle_id')
                                ->where('participants.paid', '>', 0)
                                ->where('participants.affiliate_id', $affiliateId)
                                ->select('raffles.id', DB::raw('SUM(participants.amount) as total, SUM(paid) as cotas, COUNT(participants.id) as vendas'))
                                ->groupBy('raffles.id')
                                ->get();

            dd($ganhos);
        }

        if(!empty($affiliate)){
            dd($affiliate);
        }

        $affiliates = $user->affiliate()->paginate();

        return Inertia::render('Seller/Affiliate/AffiliateIndex', ['data' => $affiliates]);
    }

    public function created()
    {
        return Inertia::render('Seller/Affiliate/AffiliateCreated');
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
             return response()->json([
                'message' => 'Afiliado adiciondo com sucesso!',
                'data' => $affiliate
            ], 200);
        } catch (QueryException $e) {
            DB::rollBack();
            setLogErros('AffiliateController', $e->getMessage(), $request->all());
            return response()->json(['message' => 'Problema ao inserir afiliado, verifique os campos!'], 403);
        }

    }
}
