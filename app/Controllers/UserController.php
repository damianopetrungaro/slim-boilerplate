<?php
namespace App\Controllers;

use App\Repositories\Users\UserRepositoryInterface;
use App\Responses\ApiResponse;
use App\Services\UserService;
use App\Validators\Users\StoreUserValidator;
use App\Validators\Users\UpdateUserValidator;
use Slim\Http\Request;

class UserController
{

    private $apiResponse;

    private $userRepository;


    public function __construct(ApiResponse $apiResponse, UserRepositoryInterface $userRepository)
    {
        $this->apiResponse    = $apiResponse;
        $this->userRepository = $userRepository;
    }


    public function index()
    {
        if ( ! $users = $this->userRepository->index()) {
            var_dump('NOPE');
        }

        var_dump($users);
    }


    public function show($id)
    {
        if ( ! $user = $this->userRepository->show($id)) {
            var_dump('NOPE');
        }

        var_dump($user);
    }


    public function store(Request $request, StoreUserValidator $validator, UserService $userService)
    {
        if ( ! $validator->validate()) {
            return $this->apiResponse->errorValidation($validator->errors());
        }

        if ( ! $user = $userService->store($request->getParams())) {
            var_dump('User not created');
            die();
        }

        var_dump('User stored');

    }


    public function update(UpdateUserValidator $validator)
    {
        var_dump($validator);
        die();
    }
}