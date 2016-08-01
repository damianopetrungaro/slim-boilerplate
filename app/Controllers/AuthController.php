<?php

namespace App\Controllers;

use App\Acme\Helpers\Mailer;
use App\Acme\JWT\JWT;
use Illuminate\Database\Capsule\Manager;
use Illuminate\Database\Connection;
use Illuminate\Database\DatabaseManager;
use Illuminate\Support\Facades\DB;
use Slim\Http\Request;
use App\Services\AuthService;
use App\Responses\ApiResponse;
use App\Exceptions\GenericException;
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

        try {
            $user = $this->authService->login($request->getParams());
        } catch (GenericException $e) {
            return $this->apiResponse->error($e->getTitle(), $e->getDetails(), $e->getStatus());
        }

        return $this->jwt->encode($user);
    }

    public function logout()
    {
        //@TODO: Think a blacklist
    }

    public function recovery(Request $request, RecoveryAuthValidator $validator, Connection $db, Mailer $mailer)
    {
        if (!$validator->validate()) {
            return $this->apiResponse->errorValidation($validator->errors());
        }

        try {
            $db->beginTransaction();
            $this->authService->recovery($request->getParam('email'), $db, $mailer);
            $db->commit();
        } catch (GenericException $e) {
            $db->rollBack();
            return $this->apiResponse->error($e->getTitle(), $e->getDetails(), $e->getStatus());
        }

        return $this->apiResponse->success(['title' => 'Email sent']);
    }

    public function reset(Request $request, ResetAuthValidator $validator)
    {
        if (!$validator->validate()) {
            return $this->apiResponse->errorValidation($validator->errors());
        }

        try {
            $this->authService->reset($request->getParams());
        } catch (GenericException $e) {
            return $this->apiResponse->error($e->getTitle(), $e->getDetails(), $e->getStatus());
        }

        return $this->apiResponse->success(['title' => 'Password updated']);
    }
}
