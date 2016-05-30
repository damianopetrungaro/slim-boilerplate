<?php
namespace App\Controllers;

use App\Services\AuthService;
use App\Transformers\Users\UserTransformer;
use Slim\Http\Request;
use App\Responses\ApiResponse;
use App\Acme\JWT\Manager as JWT;
use App\Validators\Auth\LoginAuthValidator;
use App\Repositories\Users\UserRepositoryInterface;

class AuthController
{
	private $jwt;
	private $apiResponse;
	private $userRepository;
	private $authService;

	public function __construct(ApiResponse $apiResponse, UserRepositoryInterface $userRepository, AuthService $authService, JWT $jwt)
	{
		$this->jwt = $jwt;
		$this->apiResponse = $apiResponse;
		$this->userRepository = $userRepository;
		$this->authService = $authService;
	}

	public function logged(UserTransformer $userTransformer)
	{
		$user = $this->jwt->decode();
		$data = $userTransformer->item($user);

		return $this->apiResponse->success($data, 200);
	}

	public function login(Request $request, LoginAuthValidator $validator)
	{
		if (!$validator->validate()) {
			return $this->apiResponse->errorValidation($validator->errors());
		}

		$input = $request->getParams();

		if (!$user = $this->authService->login($input)) {

			return $this->apiResponse->error('Login error', 'User not found with this credential', 400);
		}

		return $this->jwt->encode($user);
	}


	public function logout()
	{
		//@TODO: Think a blacklist
	}

	public function register()
	{
		//
	}

	public function reset()
	{
		//
	}
}