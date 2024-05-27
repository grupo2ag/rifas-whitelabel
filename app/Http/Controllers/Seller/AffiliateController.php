<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
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
            setLogErros('AffiliateController', $e->getMessage(), $request->all());
            DB::rollBack();
            return response()->json(['message' => 'Problema ao inserir afiliado, verifique os campos!'], 403);
        }

    }
}
