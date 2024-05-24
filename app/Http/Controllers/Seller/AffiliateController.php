<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Affiliate;
use Illuminate\Http\Request;
use Inertia\Inertia;

class AffiliateController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $affiliates = $user->affiliate()->paginate();

        return Inertia::render('Seller/Affiliate/AffiliateIndex', ['data' => $affiliates]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'require|string|max:255',
            'link' => 'require|string|max:255',
            'phone' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'document' => 'string|max:255',
            'description' => 'string|max:255',
            'pix_key' => 'required|string|max:255'
        ]);

        $dados = $request->all();
        $dados['user_id'] = auth()->user();

        $affiliate = Affiliate::create($dados);
        //dd($affiliate);
        return response()->json($affiliate);
    }
}
