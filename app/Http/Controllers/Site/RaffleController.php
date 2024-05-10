<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Participant;
use App\Models\Raffle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Inertia\Inertia;

class RaffleController extends Controller
{
    private $user_id;

    public function __construct()
    {
        $this->user_id = (!empty(inertia()->getShared('siteconfig')->user_id)) ? inertia()->getShared('siteconfig')->user_id : false;

        if(!$this->user_id) return Inertia::render('Welcome');//return redirect('/');
    }

    public function index($url)
    {
        $rifa = Raffle::with('raffle_images', 'raffle_awards', 'raffle_promotions', 'raffle_premium_numbers')
                        ->Slug($url)
                        ->UserID($this->user_id)
                        ->Visible(true)
                        ->first([
                            DB::raw("CASE WHEN raffles.type = '".Raffle::TYPE_MANUAL."' THEN raffles.numbers ELSE '' END AS r_numbers"),
                            'id',
                            'title',
                            'subtitle',
                            'pix_expired',
                            'price',
                            'quantity',
                            'type',
                            'highlight',
                            'highlight_order',
                            'minimum_purchase',
                            'maximum_purchase',
                            'visible',
                            'user_id',
                            'partial',
                            'description',
                            'gateway_id',
                            'total',
                            'banner'
                        ]);

        if(!empty($rifa)){
            $participant = Participant::where('raffle_id', $rifa->id)->sum('paid');

            $totalSales = $participant*100/$rifa->quantity;
            $totalSales = ($participant > 0) ? ceil($totalSales) : 0.00;

            $rifa['percent'] = $totalSales;

            return Inertia::render('Site/Raffle/Raffle', ['raffle' => $rifa]);
        }

        return redirect('/');
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
