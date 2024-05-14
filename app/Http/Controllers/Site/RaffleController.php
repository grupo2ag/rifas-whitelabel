<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RaffleController extends Controller
{
    public function index()
    {


        return Inertia::render('Site/Raffle/Raffle');

    }

    public function pay()
    {
        return Inertia::render('Site/Payment/PaymentIndex');
    }


    public function verify($phone)
    {

//        dd($phone);

        $data = [];

        return response()->json($data, 200);
    }

    public function purchase(Request $request)
    {

//        dd($phone);

        return Inertia::render('Site/Raffle/Raffle');
    }

}
