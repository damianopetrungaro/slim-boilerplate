<?php

namespace App\Controllers;

use Slim\Http\Request;
use App\Services\UserService;
use App\Responses\ApiResponse;
use App\Transformers\Users\UserTransformer;
use App\Validators\Users\StoreUserValidator;
use App\Validators\Users\UpdateUserValidator;
use App\Repositories\Users\UserRepositoryInterface;

class UserController
{
    private $apiResponse;
    private $userRepository;
    private $userTransformer;

    public function __construct(ApiResponse $apiResponse, UserRepositoryInterface $userRepository, UserTransformer $userTransformer)
    {
        $this->apiResponse = $apiResponse;
        $this->userRepository = $userRepository;
        $this->userTransformer = $userTransformer;
    }

    public function index()
    {
        if (!$users = $this->userRepository->index()) {
            return $this->apiResponse->error('Users not found', 'List of user is not available or not exists', 404, $users);
        }

        $data = $this->userTransformer->collection($users);

        return $this->apiResponse->success($data);
    }

    public function show($id)
    {
        if (!$user = $this->userRepository->show($id)) {
            return $this->apiResponse->error('User not found', 'The user is not available or not exists', 404, $user);
        }

        $data = $this->userTransformer->item($user);

        return $this->apiResponse->success($data);
    }

    public function store(Request $request, StoreUserValidator $validator, UserService $userService)
    {
        if (!$validator->validate()) {
            return $this->apiResponse->errorValidation($validator->errors());
        }

        if (!$user = $userService->store($request->getParams())) {
            return $this->apiResponse->error('User not created', 'The user has not been created', 500, $user);
        }

        $data = $this->userTransformer->item($user);

        return $this->apiResponse->success($data, 201);
    }

    public function update($id, Request $request, UpdateUserValidator $validator, UserService $userService)
    {
        if (!$validator->validate()) {
            return $this->apiResponse->errorValidation($validator->errors());
        }

        if (!$user = $userService->update($id, $request->getParams())) {
            return $this->apiResponse->error('User not updated', 'The user not exists or has not been updated', 500, $user);
        }

        return $this->apiResponse->success('User updated');
    }

    public function delete($id)
    {
        if (!$user = $this->userRepository->delete($id)) {
            return $this->apiResponse->error('User not deleted', 'The user not exists or has not been deleted', 500, $user);
        }

        return $this->apiResponse->success('User deleted');
    }
}
