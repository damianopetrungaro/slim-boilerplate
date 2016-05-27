<?php
namespace App\Controllers;

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

    public function __construct(ApiResponse $apiResponse, UserRepositoryInterface $userRepository, JWT $jwt)
    {
        $this->jwt = $jwt;
        $this->apiResponse = $apiResponse;
        $this->userRepository = $userRepository;
    }

    public function logged(Request $request)
    {
            $this->jwt->decode();
    }

    public function login(Request $request, LoginAuthValidator $validator)
    {
        //
    }


    public function logout(Request $request)
    {
        //
    }

    public function register(Request $request)
    {
        //
    }

    public function reset(Request $request)
    {
        //
    }
}