<?php

declare(strict_types=1);

namespace App\Validators\Auth;

use App\Validators\AbstractValidator;

class ResetAuthValidator extends AbstractValidator
{
    /**
     * {@inheritdoc}
     */
    public function rules():array
    {
        return [
            ['exists', 'email', ['users' => 'email']],
            ['required', ['email', 'password', 'token']],
            ['equals', 'password', 'password_confirmation'],
        ];
    }
}
