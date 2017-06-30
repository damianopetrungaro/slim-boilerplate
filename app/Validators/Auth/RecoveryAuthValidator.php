<?php

declare(strict_types=1);

namespace App\Validators\Auth;

use App\Validators\AbstractValidator;

class RecoveryAuthValidator extends AbstractValidator
{
    /**
     * {@inheritdoc}
     */
    public function rules():array
    {
        return [
            ['required', ['email']],
            ['exists', 'email', ['users' => 'email']],
        ];
    }
}
