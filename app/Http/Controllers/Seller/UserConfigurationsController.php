<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class UserConfigurationsController extends Controller
{
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'theme' => 'string',
            'primary_color' => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()], 403);
        }

        try {
            $user = auth()->user();
            $userConfigurations = $user->userConfigurations()->update($request->all());
            //dd($userConfigurations, $user);
            // foreach ($request->all() as $key => $value) {
            //     $user->userConfigurations()->update([$key => $value]);
            // }
            return response()->json([
                'message' => 'Dados do usuário alterados com sucesso!',
                'data' => [$userConfigurations]
            ], 200);
        } catch (QueryException $e) {
            DB::rollBack();
            setLogErros('UserConfigurationsController', $e->getMessage(), $request->all());
            return response()->json(['message' => 'Problema ao alterar dados do usuario'], 403);
        }
    }
}
