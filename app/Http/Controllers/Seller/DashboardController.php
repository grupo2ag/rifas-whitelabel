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
        //$data['total_affiliates'] = Affiliate::count();
        $data['total_rifas'] = Raffle::count();
        $data['total_numeros'] = Raffle::sum('quantity');
        $data['total_vendido'] = Raffle::select(DB::raw('TRUNC((COALESCE(SUM(price), 0))/100,2) AS total'))->first()->total;
        $data['total_participantes'] = Raffle::sum('price');
        //$data['uuid'] = '1234';

        return Inertia::render('Panel/User/Dashboard', $data);
//        return Inertia::render('Seller/Raffle/RaffleIndex');
    }
}
