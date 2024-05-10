<?php

namespace App\Http\Controllers\Site;

use App\Http\Controllers\Controller;
use App\Models\Raffle;
use Illuminate\Http\Request;
use Inertia\Inertia;

class HomeController extends Controller
{
    public function index()
    {
        if(!empty(inertia()->getShared('siteconfig')->user_id)){
            $user_id = inertia()->getShared('siteconfig')->user_id;

            $raffles = Raffle::UserID($user_id)
                ->orderBy('highlight', 'DESC')
                ->orderBy('highlight_order', 'ASC')
                ->orderBy('status', 'ASC')
                ->with(['raffle_images' => function ($query) {
                    $query->whereRaw('raffle_images.id IN (SELECT MAX(a2.id) FROM raffle_images AS a2 WHERE a2.id = raffle_images.id AND highlight = 1)');
                }])
                ->with(['raffle_awards' => function ($query) {
                    $query->whereRaw('raffle_awards.id IN (SELECT MAX(a2.id) FROM raffle_awards AS a2 WHERE a2.id = raffle_awards.id AND raffle_awards.order = 1)');
                }])
                ->get();

            $raffles->each(function ($each){
                $each->load(['raffle_images' => function ($q) {
                    return $q->latest();
                }]);
            });

            $raffles->each(function ($each){
                $each->load(['raffle_awards' => function ($q) {
                    return $q->first();
                }]);
            });

            return Inertia::render('Site/Home/Home', ['data' => $raffles]);
        }

        return Inertia::render('Welcome');

    }
}
