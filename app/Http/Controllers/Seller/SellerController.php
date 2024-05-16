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
use Illuminate\Support\Facades\Validator;
use Inertia\Inertia;

class SellerController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if(!$user){
            return Inertia::render('Auth/Login');
        }
        $data = $user->raffles()->orderBy('id')->paginate();

        foreach ($data->items() as $key => $value) {
            $raffle = $user->raffles()->ofId($value['id'])->first();
            $data->items()[$key]['paid'] = $raffle->participants()->sum('paid');
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

        $data['participants']['data'] = $raffle->participants()->orderBy('id')->paginate();

        $data['participants']['distinct'] = $raffle->participants()->select('document')->distinct('document')->count();
        $data['participants']['ranking'] = $raffle->participants()->select('document', 'name', 'email', DB::raw('COUNT(*) as quantity'), DB::raw('SUM(amount) as total_value'))->groupBy('document', 'name', 'email')->orderByDesc('total_value')->take(3)->get();

        $data['raffle']['image'] = $raffle->raffle_images()->first();
        $data['raffle']['paid'] = $raffle->participants()->sum('paid');

      // dd('Aqui');
        return Inertia::render('Seller/Raffle/RaffleView', ['data'=> $data]);
    }

    public function created(Request $request)
    {
        $data['quantity_numbers'] = [
            ['value' => 100, 'texto' => '100 cotas - (0 à 99)'],
            ['value' => 1000, 'texto' => '1.000 cotas - (0 à 999)', 'selected' => true],
            ['value' => 5000, 'texto' => '5.000 cotas - (0 à 4.999)'],
            ['value' => 10000, 'texto' => '10.000 cotas - (0 à 9.999)'],
            ['value' => 100000, 'texto' => '100.000 cotas - (0 à 99.999)'],
            ['value' => 1000000, 'texto' => '1.000.000 cotas - (0 à 999.999)'],
            ['value' => 10000000, 'texto' => '10.000.000 cotas - (0 à 9.999.999)']
        ];

        return Inertia::render('Seller/Raffle/RaffleCreate', $data);
    }

    public function store(Request $request)
    {
        //dd($request->all());
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|min:1|max:255',
            'subtitle' => 'required|string|min:1|max:255',
            'pix_expired' => 'required',
            'buyer_ranking' => 'required',
            'link' => 'required',
            'price' => 'required',
            'status' => 'required',
            'quantity_numbers' => 'required',
            'type' => 'required',
            'highlight' => 'required',
            'minimum_purchase' => 'required',
            'maximum_purchase' => 'required',
            //'visible' => 'required',
            'description' => 'required',
            'gateway_id' => 'required',
            'banner' => 'required',
            'partial' => 'required',
            'awards' => 'required|string|min:1|max:255'
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()], 403);
        }

        dd($request->all());
    }
}
