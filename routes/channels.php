<?php

use Illuminate\Support\Facades\Broadcast;

/*Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});*/

Broadcast::channel('Processed.Pix.{id}', function ($order_id) {
    //info(__METHOD__.' Hit! User: '.json_encode(compact($order_id)));
    //return \App\Models\LogSales::where('id_charge', $uuid)->first()->clients_id;
    return true;
});
