<?php

namespace App\Validators\Auth;

use App\Validators\AbstractValidator;

class LoginAuthValidator extends AbstractValidator
{
	public function rules()
	{
		return [
			['exists', 'email', ['users' => 'email']],
			['required', ['password', 'email']],
		];
	}
}