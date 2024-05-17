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

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return Inertia::render('Auth/Login');
        }

        $data['raffles']['total_raffles_active'] = $user->raffles()->where('status', 'Ativo')->count();
        $data['raffles']['total_raffles_finished'] = $user->raffles()->where('status', 'Encerrado')->count();
        $data['raffles']['total_raffles'] = $user->raffles()->count();
        $data['raffles']['data'] = $user->raffles()->orderByDesc('id')->take(4)->get()->toArray();

        foreach ($data['raffles']['data'] as $key => $value) {
            $raffle = $user->raffles()->ofId($value['id'])->first();
            $data['raffles']['data'][$key]['paid'] = $raffle->participants()->sum('paid');
        }

        //$data['total_affiliates'] = Affiliate::count();
        // $data['total_rifas'] = Raffle::count();
        // $data['total_numeros'] = Raffle::sum('quantity');
        // $data['total_vendido'] = Raffle::select(DB::raw('TRUNC((COALESCE(SUM(price), 0))/100,2) AS total'))->first()->total;
        // $data['total_participantes'] = Raffle::sum('price');


        //$data['uuid'] = '1234';

        return Inertia::render('Panel/User/Dashboard', ['data' => $data]);
    }
}
