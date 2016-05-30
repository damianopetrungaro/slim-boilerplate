<?php

namespace App\Validators\Auth;

use App\Validators\AbstractValidator;

class RecoveryAuthValidator extends AbstractValidator
{
    public function rules()
    {
        return [
            ['required', ['email']],
            ['exists', 'email', ['users' => 'email']],
        ];
    }
}
