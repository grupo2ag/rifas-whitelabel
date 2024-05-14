<?php

namespace App\Http\Controllers\Site;
use Laravel\Jetstream\Jetstream;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{

    public function index(Request $request)
    {

        return Inertia::render('Site/Home/Home');
    }
}
