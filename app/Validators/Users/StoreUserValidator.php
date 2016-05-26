<?php

namespace App\Validators\Users;

use App\Validators\AbstractValidator;

class StoreUserValidator extends AbstractValidator
{

    public function rules()
    {
        return [
            ['required', ['name', 'surname', 'email', 'password']],
            ['email', ['email']],
            ['equals', 'password', 'password_confirmation']
        ];
    }
}