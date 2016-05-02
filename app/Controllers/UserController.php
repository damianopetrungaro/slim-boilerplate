<?php
namespace App\Controllers;

use App\Responses\ApiResponse;
use App\Validators\Users\StoreUserValidator;
use App\Validators\Users\UpdateUserValidator;

class UserController
{
    private $apiResponse;

    public function __construct(ApiResponse $apiResponse)
    {
        $this->apiResponse = $apiResponse;
    }


    public function index()
    {
    }


    public function show()
    {
    }


    public function store(StoreUserValidator $validator)
    {
        if(!$validator->validate()) {
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