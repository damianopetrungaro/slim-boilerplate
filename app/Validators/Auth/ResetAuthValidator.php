<?php

namespace App\Validators\Auth;

use App\Validators\AbstractValidator;

class ResetAuthValidator extends AbstractValidator
{
	public function rules()
	{
		return [
			['exists', 'email', ['users' => 'email']],
			['required', ['email', 'password', 'token']],
			['equals', 'password', 'password_confirmation']
		];
	}
}