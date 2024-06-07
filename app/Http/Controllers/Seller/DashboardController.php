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
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;

class DashboardController extends Controller
{
    private $user;

    public function __construct()
    {
        $this->user = auth()->user();

        $gateway = $this->user->gatewayConfigurations()->first();
        //dd($gateway->login);

        if(empty($gateway->token) || empty($gateway->login) ){
            //dd('aqui');
            return \redirect('paymentMethods')->with(['message' => 'Primeiro configure o '])->send();//;
        }

    }

    public function index()
    {
        $user = auth()->user();

        $gateway = $user->gatewayConfigurations()->first();

        if(empty($gateway->token) || empty($gateway->login)){
            return redirect()->route('paymentMethods')->with('message', 'Primeiro passo configure o Gateway');
        }

        $data['raffles']['total_raffles_active'] = $user->raffles()->where('status', 'Ativo')->count();
        $data['raffles']['total_raffles_finished'] = $user->raffles()->where('status', 'Finalizado')->count();
        $data['raffles']['total_raffles'] = $user->raffles()->count();
        $data['raffles']['data'] = $user->raffles()->orderByDesc('id')->take(4)->get()->toArray();

        //Filtra os 3 maiores compradores das rifas do usuario logado
        $data['raffles']['ranking'] = Participant::join('raffles', 'participants.raffle_id', '=', 'raffles.id')
            ->where('raffles.user_id', $user->id)
            ->select('participants.document', 'participants.name', 'participants.email', DB::raw('SUM(participants.amount) as total_amount'))
            ->groupBy('participants.document', 'participants.name', 'participants.email')
            ->orderByDesc('total_amount')
            ->limit(3)
            ->get()
            ->toArray();

        $data['grafics'] = [
            //Filtra participantes por dia que compram as rifas do usuario logado
            'participantsPerDay' => Participant::join('raffles', 'participants.raffle_id', '=', 'raffles.id')
            ->where('raffles.user_id', $user->id)
            ->select(DB::raw('DATE(participants.created_at) as date'), DB::raw('COUNT(DISTINCT participants.document) as value'))
            ->groupBy(DB::raw('DATE(participants.created_at)'))
            ->orderBy('date', 'asc')
            ->get()
            ->toArray(),
            //Filtra rifas pagas por dia das rifas do usuario logado
            'paidPerDay' => Participant::join('raffles', 'participants.raffle_id', '=', 'raffles.id')
            ->where('raffles.user_id', $user->id)
            ->select(DB::raw('DATE(participants.created_at) as date'), DB::raw('SUM(participants.paid) as value'))
            ->groupBy(DB::raw('DATE(participants.created_at)'))
            ->orderBy('date', 'asc')
            ->get()
            ->toArray(),
            //Filtra rifas expiradas por dia das rifas do usuario logado
            'reservedPerDay' => Participant::join('raffles', 'participants.raffle_id', '=', 'raffles.id')
            ->where('raffles.user_id', $user->id)
            ->select(DB::raw('DATE(participants.created_at) as date'), DB::raw('(SUM(participants.reserved)) as value'))
            ->groupBy(DB::raw('DATE(participants.created_at)'))
            ->orderBy('date', 'asc')
            ->get()
            ->toArray()
        ];

        foreach ($data['raffles']['data'] as $key => $value) {
            $raffle = $user->raffles()->ofId($value['id'])->first();
            $data['raffles']['data'][$key]['paid'] = $raffle->participants()->sum('paid');

            $image = $raffle->raffle_images()->first();

            if (!empty($image))
                $data['raffles']['data'][$key]['gallery']['img'] = Storage::disk(config('filesystems.default'))->temporaryUrl($image->path, now()->addMinutes(30));
        }

//        dd($data);

        $data['configurations'] = $user->userConfigurations()->first();
        return Inertia::render('Panel/User/Dashboard', ['data' => $data]);
    }
}
