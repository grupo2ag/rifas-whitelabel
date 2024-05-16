<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use App\Models\Raffle;
use App\Models\RaffleImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class SellerController extends Controller
{
    public function index()
    {

        //$data['total_affiliates'] = Affiliate::count();
        $data['total_rifas'] = Raffle::count();
        $data['total_numeros'] = Raffle::sum('quantity');
        $data['total_vendido'] = Raffle::select(DB::raw('TRUNC((COALESCE(SUM(price), 0))/100,2) AS total'))->first()->total;
        $data['total_participantes'] = Raffle::sum('price');
        //$data['uuid'] = '1234';

        return Inertia::render('Panel/User/Dashboard', $data);
//        return Inertia::render('Seller/Raffle/RaffleIndex');
    }

    public function view(Request $request, $id)
    {
        $user = Auth::user();
        if(!$user){
            return Inertia::render('Auth/Login');
        }

        $raffle = $user->raffles()->ofId($id)->first();

        $data['raffle'] = $raffle ? $raffle : '';

        $data['grafics'] = [
            'participants' => $raffle->participants()->select(DB::raw('DATE(created_at) as date'), DB::raw('COUNT(DISTINCT document) as value'))
            ->groupBy(DB::raw('DATE(created_at)'))->get(),
            'paid' => $raffle->participants()->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(paid) as value'))
            ->groupBy(DB::raw('DATE(created_at)'))->get(),
            'expired' => $raffle->participants()->select(DB::raw('DATE(created_at) as date'), DB::raw('(SUM(reserved) - SUM(paid)) as value'))
            ->groupBy(DB::raw('DATE(created_at)'))->get()
        ];

        $data['participants']['data'] = $raffle->participants()->orderBy('id')->get()->toArray();
        $data['participants']['distinct'] = $raffle->participants()->select('document')->distinct('document')->count();
        $data['participants']['ranking'] = $raffle->participants()->select('document', 'name', 'email', DB::raw('COUNT(*) as quantity'), DB::raw('SUM(amount) as total_value'))->groupBy('document', 'name', 'email')->orderByDesc('total_value')->take(3)->get();

        $data['raffle']['image'] = $raffle->raffle_images()->first();
        $data['raffle']['paid'] = $raffle->participants()->sum('paid');

        return Inertia::render('Seller/Raffle/RaffleView', ['data'=> $data]);
    }

    public function created(Request $request)
    {

        return Inertia::render('Seller/Raffle/RaffleCreate');
    }
}
