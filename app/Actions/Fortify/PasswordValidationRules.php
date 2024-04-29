<?php

namespace App\Actions\Fortify;

use Illuminate\Validation\Rules\Password;
use Laravel\Fortify\Rules\Password as rulesPassword;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array<int, \Illuminate\Contracts\Validation\Rule|array<mixed>|string>
     */
    protected function passwordRules(): array
    {
        return ['required',
            'string',
            Password::default(),
            'confirmed',
            (new rulesPassword)->requireUppercase(),
            (new rulesPassword)->requireNumeric(),
            (new rulesPassword)->requireSpecialCharacter()
        ];
    }
}
