<?php

declare(strict_types=1);

namespace App\Validators\Users;

use App\Validators\AbstractValidator;

class UpdateUserValidator extends AbstractValidator
{
    /**
     * {@inheritdoc}
     */
    public function rules():array
    {
        return [
            ['required', ['name', 'surname']],
        ];
    }
}
