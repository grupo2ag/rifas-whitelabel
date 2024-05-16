<?php

namespace App\Http\Controllers\Site;
use Laravel\Jetstream\Jetstream;

use App\Http\Controllers\Controller;
use App\Models\Raffle;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    private $user_id;

    public function __construct()
    {
        $this->user_id = (!empty(inertia()->getShared('siteconfig')->user_id)) ? inertia()->getShared('siteconfig')->user_id : false;

        if(!$this->user_id) return Inertia::render('Welcome');//return redirect('/');
    }

    public function index()
    {

        $raffles = Raffle::UserID($this->user_id)
            ->orderBy('highlight', 'DESC')
            ->orderBy('highlight_order', 'ASC')
            ->with(['raffle_images' => function ($query) {
                $query->whereRaw('raffle_images.id IN (SELECT MAX(a2.id) FROM raffle_images AS a2 WHERE a2.id = raffle_images.id AND highlight = 1)');
            }])
            ->Exclude(['numbers', 'video'])
            ->Status('Ativo')
            ->get();

        $rafflesFinish = Raffle::UserID($this->user_id)
            ->orderBy('finish_at', 'DESC')
            ->with(['raffle_images' => function ($query) {
                $query->whereRaw('raffle_images.id IN (SELECT MAX(a2.id) FROM raffle_images AS a2 WHERE a2.id = raffle_images.id AND highlight = 1)');
            }])
            ->with(['raffle_awards' => function ($query) {
                $query->whereRaw('raffle_awards.id IN (SELECT MAX(a2.id) FROM raffle_awards AS a2 WHERE a2.id = raffle_awards.id AND raffle_awards.order = 1)');
            }])
            ->Exclude(['numbers', 'video'])
            ->Status('Finalizado')
            ->paginate();

        //dd($raffles);
        return Inertia::render('Site/Home/Home', ['raffles' => $raffles, 'rafflesFinish' => $rafflesFinish]);
    }
}
