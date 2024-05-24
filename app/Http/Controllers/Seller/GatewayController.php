<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
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
        };

        return Inertia::render('Seller/PaymentMethods/PaymentMethodsIndex', ['data' => $data]);
    }
}
