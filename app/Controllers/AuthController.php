<?php
namespace App\Controllers;

use Slim\Http\Request;
use App\Responses\ApiResponse;
use App\Repositories\Users\UserRepositoryInterface;

class AuthController
{
    private $apiResponse;

    private $userRepository;

    public function __construct(ApiResponse $apiResponse, UserRepositoryInterface $userRepository)
    {
        $this->apiResponse = $apiResponse;
        $this->userRepository = $userRepository;
    }

    public function logged(Request $request)
    {
        //
    }

    public function login()
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