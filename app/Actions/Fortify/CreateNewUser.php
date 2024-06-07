<?php

namespace App\Actions\Fortify;

use App\Models\User;
use Doctrine\DBAL\Query\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Validate and create a newly registered user.
     *
     * @param  array<string, string>  $input
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'document' => ['required', 'string', 'document', 'max:30', 'unique:users'],
            'phone' => ['required', 'string', 'phone', 'max:20', 'unique:users'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ]);

        try {
            $user = User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'document' => $input['document'],
                'phone' => $input['phone'],
                'password' => Hash::make($input['password']),
                'level' => 1
            ]);

            if($user) {
                $user->userConfigurations()->create([
                    'primary_color' => '255 164 45',
                    'user_id' => $user->id,
                    'theme' => 'dark',
                    'register_cpf' => $user->document,
                    'register_email' => $user->email
                ]);
            }
            return $user;
        }catch(QueryException $e) {
            DB::rollBack();
            setLogErros('CreateNewUser', $e->getMessage());
            return response()->json(['message' => 'Problema ao inserir novo usuário'], 403);
        }
    }
}
