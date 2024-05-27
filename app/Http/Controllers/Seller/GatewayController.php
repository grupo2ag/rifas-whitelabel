<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\GatewayConfiguration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class GatewayController extends Controller
{

    public function index()
    {
        $user = auth()->user();
        $data = [];

        foreach ($user->gatewayConfigurations()->get() as $key => $config) {
            $gateway = $config->gateway()->first()->toArray();
            $gateway['config'] = $config->toArray();
            array_push($data, $gateway);
        }

        return Inertia::render('Seller/PaymentMethods/PaymentMethodsIndex', ['data' => $data]);
    }

    public function store(Request $request){
        $user = auth()->user();

        $request->validate([
            'token' => 'required|string|max:255',
            'login' => 'required|email|max:255'
        ]);

        $return = GatewayConfiguration::updateOrCreate(
            [
                'user_id'   => $user->id
            ],
            [
                'token' => $request->token,
                'login' => $request->login,
                'gateway_id' => 1
            ]
        );

        return redirect()->back();//->with('message', 'Settings saved successfully');
    }
}
