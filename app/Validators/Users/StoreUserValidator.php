<?php

declare(strict_types=1);

namespace App\Validators\Users;

use App\Validators\AbstractValidator;

class StoreUserValidator extends AbstractValidator
{
    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            ['email', ['email']],
            ['unique', 'email', ['users' => 'email']],
            ['equals', 'password', 'password_confirmation'],
            ['required', ['name', 'surname', 'email', 'password']],
        ];
    }
}
