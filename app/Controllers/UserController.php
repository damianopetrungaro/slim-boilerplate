<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Repositories\Users\UserRepositoryInterface;
use App\Responses\ApiResponse;
use App\Services\UserService;
use App\Transformers\Users\UserTransformer;
use App\Validators\Users\StoreUserValidator;
use App\Validators\Users\UpdateUserValidator;
use Slim\Http\Request;
use Slim\Http\Response;

class UserController
{
    /**
     * @var ApiResponse
     */
    private $apiResponse;
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;
    /**
     * @var UserTransformer
     */
    private $userTransformer;

    /**
     * UserController constructor.
     *
     * @param ApiResponse $apiResponse
     * @param UserRepositoryInterface $userRepository
     * @param UserTransformer $userTransformer
     */
    public function __construct(ApiResponse $apiResponse, UserRepositoryInterface $userRepository, UserTransformer $userTransformer)
    {
        $this->apiResponse = $apiResponse;
        $this->userRepository = $userRepository;
        $this->userTransformer = $userTransformer;
    }

    /**
     * Return list of users
     *
     * @return Response
     */
    public function index(): Response
    {
        if (!$users = $this->userRepository->index()) {
            return $this->apiResponse->error('Users not found', 'List of user is not available or not exists', 404, $users);
        }

        $data = $this->userTransformer->collection($users);

        return $this->apiResponse->success($data);
    }

    /**
     * Get a specific User
     *
     * @param int $id
     *
     * @return Response
     */
    public function show(int $id): Response
    {
        if (!$user = $this->userRepository->show($id)) {
            return $this->apiResponse->error('User not found', 'The user is not available or not exists', 404, $user);
        }

        $data = $this->userTransformer->item($user);

        return $this->apiResponse->success($data);
    }

    /**
     * Add a new User
     *
     * @param Request $request
     * @param StoreUserValidator $validator
     * @param UserService $userService
     *
     * @return Response
     */
    public function store(Request $request, StoreUserValidator $validator, UserService $userService): Response
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

    /**
     * Update user data
     *
     * @param int $id
     * @param Request $request
     * @param UpdateUserValidator $validator
     * @param UserService $userService
     *
     * @return Response
     */
    public function update(int $id, Request $request, UpdateUserValidator $validator, UserService $userService): Response
    {
        if (!$validator->validate()) {
            return $this->apiResponse->errorValidation($validator->errors());
        }

        if (!$user = $userService->update($id, $request->getParams())) {
            return $this->apiResponse->error('User not updated', 'The user not exists or has not been updated', 500, $user);
        }

        return $this->apiResponse->success('User updated');
    }

    /**
     * Delete User
     *
     * @param int $id
     *
     * @return Response
     */
    public function delete(int $id): Response
    {
        if (!$user = $this->userRepository->delete($id)) {
            return $this->apiResponse->error('User not deleted', 'The user not exists or has not been deleted', 500, $user);
        }

        return $this->apiResponse->success('User deleted');
    }
}
