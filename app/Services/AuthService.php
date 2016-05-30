<?php

namespace App\Services;

use App\Acme\Helpers\Mailer;
use App\Acme\Helpers\Str;
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

		if ($user = $this->userRepository->getByEmailAndPassword($email, $password)) {
			return $user->toArray();
		}

		return false;
	}

	public function reset(array $input)
	{
		$email = $input['email'];
		$token = $input['token'];
		$password = md5($input['password']);

		if (!$user = $this->userRepository->getByEmailAndResetToken($email, $token)) {
			return ['title' => 'User not found', 'message' => 'Password not updated', 'status' => 404];
		}

		if (!$this->userRepository->update($user['id'], ['reset_password' => '', 'password' => $password])) {
			return ['title' => 'Error updating user', 'message' => 'Password not updated', 'status' => 500];
		}

		return true;
	}

	public function recovery($email)
	{
		if (!$user = $this->userRepository->getByEmail($email)) {
			return ['title' => 'User not found', 'message' => 'No user was found with this email', 'status' => 404];
		}

		$token = Str::random(55);

		if (!$this->userRepository->update($user['id'], ['reset_password' => $token])) {
			return ['title' => 'Error updating user', 'message' => 'A problem occurred trying to update the user', 'status' => 500];
		}

		try {
			Mailer::send('Rest Password', [$email], 'Token is: ' . $token);
		} catch (\Exception $e) {
			return ['title' => 'Error sending the email', 'message' => $e->getMessage(), 'status' => 500];
		}
	}
}