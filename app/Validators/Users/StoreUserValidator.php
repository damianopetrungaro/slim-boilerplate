<?php

namespace App\Validators\Users;

use App\Validators\AbstractValidator;

class StoreUserValidator extends AbstractValidator
{
    public function rules()
    {
        return [
            ['email', ['email']],
            ['unique', 'email', ['users' => 'email']],
            ['equals', 'password', 'password_confirmation'],
            ['required', ['name', 'surname', 'email', 'password']],
        ];
    }
}
