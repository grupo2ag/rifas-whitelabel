<?php

namespace App\Http\Controllers\Seller;

use App\Http\Controllers\Controller;
use App\Models\User;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Rules\Password as rulesPassword;
use Laravel\Jetstream\Jetstream;

class UserController extends Controller
{
    protected function passwordRules(): array
    {
        return [
            'required',
            'string',
            Password::default(),
            'confirmed',
            (new rulesPassword)->requireUppercase(),
            (new rulesPassword)->requireNumeric(),
            (new rulesPassword)->requireSpecialCharacter()
        ];
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'document' => ['required', 'string', 'max:30', 'unique:users'],
            'phone' => ['required', 'string', 'max:20', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->messages()], 403);
        }

        try {
            $user = User::create([
                'name' => $request['name'],
                'email' => $request['email'],
                'document' => $request['document'],
                'phone' => $request['phone'],
                'password' => Hash::make($request['password']),
                'level' => 1
            ]);

            if ($user) {
                $user->userConfigurations()->create([
                    'primary_color' => '255 164 45',
                    'user_id' => $user->id,
                    'theme' => 'dark',
                    'register_cpf' => $user->document,
                    'register_email' => $user->email
                ]);

                $user->gatewayConfigurations()->create([
                    'user_id' => $user->id,
                    'gateway_id' => 1
                ]);
            }
            return response()->json(['message' => 'Usuário criado com sucesso!'], 200);
        } catch (QueryException $e) {
            DB::rollBack();
            setLogErros('CreateNewUser', $e->getMessage());
            return response()->json(['message' => 'Problema ao inserir novo usuário'], 403);
        }
    }
}
