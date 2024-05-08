<?php

namespace App\Http\Controllers\Admin;

use App\Models\Affiliate;
use App\Models\Raffle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class DashboardController
{

    public function index(){

        //$data['total_affiliates'] = Affiliate::count();
        $data['total_rifas'] = Raffle::count();
        $data['total_numeros'] = Raffle::sum('quantity');
        $data['total_vendido'] = Raffle::select(DB::raw('TRUNC((COALESCE(SUM(price), 0))/100,2) AS total'))->first()->total;
        $data['total_participantes'] = Raffle::sum('price');
        //$data['uuid'] = '1234';

        return Inertia::render('Admin/Dashboard', $data);
    }

}
