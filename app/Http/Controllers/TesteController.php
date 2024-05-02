<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TesteController extends Controller
{
    public function index()
    {
        //dd(numbers_generate(100000));

        dd(numbers_reserve(1, 100));
        //dd(numbers_available(1));
    }
}
