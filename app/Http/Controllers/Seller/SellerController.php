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
        $user = Auth::user();
        if(!$user){
            return Inertia::render('Auth/Login');
        }
        $data = $user->raffles()->get()->toArray();

        foreach ($data as $key => $value) {
            $raffle = $user->raffles()->ofId($value['id'])->first();
            $data[$key]['paid'] = $raffle->participants()->sum('paid');
        }
        return Inertia::render('Seller/Raffle/RaffleIndex', ['data'=> $data]);

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

      // dd('Aqui');
        return Inertia::render('Seller/Raffle/RaffleView', ['data'=> $data]);
    }

    public function created(Request $request)
    {

        return Inertia::render('Seller/Raffle/RaffleCreate');
    }
}
