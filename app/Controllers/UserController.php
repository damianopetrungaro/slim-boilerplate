<?php
namespace App\Controllers;

use App\Repositories\Users\UserRepositoryInterface;
use App\Responses\ApiResponse;
use App\Validators\Users\StoreUserValidator;
use App\Validators\Users\UpdateUserValidator;

class UserController
{
	private $apiResponse;
	private $userRepository;

	public function __construct(ApiResponse $apiResponse, UserRepositoryInterface $userRepository)
	{
		$this->apiResponse = $apiResponse;
		$this->userRepository = $userRepository;
	}


	public function index()
	{
		if (!$users = $this->userRepository->index()) {
			var_dump('NOPE');
		}

		var_dump($users);
	}


	public function show()
	{

	}


	public function store(StoreUserValidator $validator)
	{
		if (!$validator->validate()) {
			return $this->apiResponse->errorValidation($validator->errors());
		}

		var_dump('Passed');
		die();
	}


	public function update(UpdateUserValidator $validator)
	{
		var_dump($validator);
		die();
	}
}