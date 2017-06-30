<?php

declare(strict_types=1);

namespace App\Validators\Auth;

use App\Validators\AbstractValidator;

class LoginAuthValidator extends AbstractValidator
{
    /**
     * {@inheritdoc}
     */
    public function rules():array
    {
        return [
            ['required', ['password', 'email']],
            ['exists', 'email', ['users' => 'email']],
        ];
    }
}
