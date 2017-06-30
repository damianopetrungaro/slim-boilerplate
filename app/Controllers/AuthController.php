<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Acme\Helpers\Mailer;
use App\Acme\JWT\JWT;
use App\Exceptions\GenericException;
use App\Responses\ApiResponse;
use App\Services\AuthService;
use App\Transformers\Users\UserTransformer;
use App\Validators\Auth\LoginAuthValidator;
use App\Validators\Auth\RecoveryAuthValidator;
use App\Validators\Auth\ResetAuthValidator;
use Illuminate\Database\Connection;
use Slim\Http\Request;
use Slim\Http\Response;

class AuthController
{
    /**
     * @var JWT
     */
    private $jwt;
    /**
     * @var ApiResponse
     */
    private $apiResponse;
    /**
     * @var AuthService
     */
    private $authService;

    public function __construct(ApiResponse $apiResponse, AuthService $authService, JWT $jwt)
    {
        $this->jwt = $jwt;
        $this->apiResponse = $apiResponse;
        $this->authService = $authService;
    }

    /**
     * Return the logged user
     *
     * @param UserTransformer $userTransformer
     *
     * @return Response
     */
    public function logged(UserTransformer $userTransformer): Response
    {
        $user = $this->jwt->decode();

        $data = $userTransformer->item($user);

        return $this->apiResponse->success($data);
    }

    /**
     * Authenticate the user and return a JWT
     *
     * @param Request $request
     * @param LoginAuthValidator $validator
     *
     * @return Response
     */
    public function login(Request $request, LoginAuthValidator $validator): Response
    {
        if (!$validator->validate()) {
            return $this->apiResponse->errorValidation($validator->errors());
        }

        $user = $this->authService->login($request->getParams());

        return $this->apiResponse->success($this->jwt->encode($user));
    }

    /**
     * Recover password
     *
     * @param Request $request
     * @param RecoveryAuthValidator $validator
     * @param Connection $db
     * @param Mailer $mailer
     *
     * @return Response
     *
     * @throws GenericException
     */
    public function recovery(Request $request, RecoveryAuthValidator $validator, Connection $db, Mailer $mailer): Response
    {
        if (!$validator->validate()) {
            return $this->apiResponse->errorValidation($validator->errors());
        }

        try {
            $db->beginTransaction();
            $this->authService->recovery($request->getParam('email'), $mailer);
            $db->commit();
        } catch (GenericException $e) {
            $db->rollBack();
            throw $e;
        }

        return $this->apiResponse->success(['title' => 'Email sent']);
    }

    /**
     * Reset user password
     *
     * @param Request $request
     * @param ResetAuthValidator $validator
     *
     * @return Response
     */
    public function reset(Request $request, ResetAuthValidator $validator): Response
    {
        if (!$validator->validate()) {
            return $this->apiResponse->errorValidation($validator->errors());
        }

        $this->authService->reset($request->getParams());

        return $this->apiResponse->success(['title' => 'Password updated']);
    }
}
