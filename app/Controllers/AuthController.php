<?php

namespace App\Controllers;

use Slim\Http\Request;
use App\Services\AuthService;
use App\Responses\ApiResponse;
use App\Acme\JWT\Manager as JWT;
use App\Transformers\Users\UserTransformer;
use App\Validators\Auth\ResetAuthValidator;
use App\Validators\Auth\LoginAuthValidator;
use App\Validators\Auth\RecoveryAuthValidator;
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

        if (!$user = $this->authService->login($request->getParams())) {
            return $this->apiResponse->error('Login error', 'User not found with this credential', 400);
        }

        return $this->jwt->encode($user);
    }

    public function logout()
    {
        //@TODO: Think a blacklist
    }

    public function recovery(Request $request, RecoveryAuthValidator $validator)
    {
        if (!$validator->validate()) {
            return $this->apiResponse->errorValidation($validator->errors());
        }

        $result = $this->authService->recovery($request->getParam('email'));

        if (is_array($result)) {
            return $this->apiResponse->error($result['title'], $result['message'], $result['status']);
        }

        return $this->apiResponse->success(['title' => 'Email sent']);
    }

    public function reset(Request $request, ResetAuthValidator $validator)
    {
        if (!$validator->validate()) {
            return $this->apiResponse->errorValidation($validator->errors());
        }

        $result = $this->authService->reset($request->getParams());

        if (is_array($result)) {
            return $this->apiResponse->error($result['title'], $result['message'], $result['status']);
        }

        return $this->apiResponse->success(['title' => 'Password updated']);
    }
}
