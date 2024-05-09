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
        if(!empty(inertia()->getShared('siteconfig')->user_id)){

            return Inertia::render('Site/Raffle/Raffle');
        }

        return Inertia::render('Welcome');
    }

    public function pay($url)
    {


        if($url){

            return Inertia::render('Site/Payment/PaymentIndex');
        } else {
            abort(404);
        }
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
