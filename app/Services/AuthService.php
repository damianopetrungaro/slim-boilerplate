<?php

namespace App\Services;

use App\Acme\JWT\Manager as JWT;
use App\Repositories\Users\UserRepositoryInterface;

class AuthService
{
	private $userRepository;
	private $jwt;

	public function __construct(UserRepositoryInterface $userRepository, JWT $jwt)
	{
		$this->userRepository = $userRepository;
		$this->jwt = $jwt;
	}


	public function login(array $input)
	{
		$email = $input['email'];
		$password = md5($input['password']); // Hash password (better if you use a key for hash)

		if ($user = $this->userRepository->getByCredential($email, $password)) {
			return $user->toArray();
		}

		return false;
	}
}