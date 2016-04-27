<?php
namespace App\Controllers;

use App\Validators\Users\StoreUserValidator;
use App\Validators\Users\UpdateUserValidator;

class UserController
{

    public function __construct()
    {
    }


    public function index()
    {
    }


    public function show()
    {
    }


    public function store(StoreUserValidator $validator)
    {
        var_dump($validator);
        die();
    }


    public function update(UpdateUserValidator $validator)
    {
        var_dump($validator);
        die();
    }
}