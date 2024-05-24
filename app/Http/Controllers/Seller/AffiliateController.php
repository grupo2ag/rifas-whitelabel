<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Inertia\Inertia;

class AffiliateController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $affiliates = $user->affiliate()->paginate();

        return Inertia::render('Seller/Affiliate/AffiliateIndex', ['data' => $affiliates]);
    }
}
