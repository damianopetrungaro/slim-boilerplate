<?php

namespace App\Validators\Auth;

use App\Validators\AbstractValidator;

class LoginAuthValidator extends AbstractValidator
{
    public function rules()
    {
        return [
            ['required', ['password', 'email']],
            ['exists', 'email', ['users' => 'email']],
        ];
    }
}
