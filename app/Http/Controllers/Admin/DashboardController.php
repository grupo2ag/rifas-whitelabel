<?php

namespace App\Http\Controllers\Admin;

use App\Models\Affiliate;
use App\Models\Customer;
use App\Models\Participant;
use App\Models\Raffle;
use Illuminate\Support\Facades\DB;
use Inertia\Inertia;

class DashboardController
{

    public function index(){

        //$user = auth()->user();

        //$data['total_affiliates'] = Affiliate::count();
        $data['total_rifas'] = Raffle::count();
        $data['total_numeros'] = Participant::where('paid', '>', 0)->sum('paid');
        $data['total_vendido'] = Participant::where('paid', '>', 0)->select(DB::raw('TRUNC((COALESCE(SUM(amount), 0))/100,2) AS total'))->first()->total;
        $data['total_participantes'] = Customer::count();

        return Inertia::render('Admin/Dashboard', $data);
    }

}
