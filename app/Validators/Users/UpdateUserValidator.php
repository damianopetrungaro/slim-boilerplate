<?php

namespace App\Validators\Users;

use App\Validators\AbstractValidator;

class UpdateUserValidator extends AbstractValidator
{
	public function rules()
	{
        $this->validate();
    }
}