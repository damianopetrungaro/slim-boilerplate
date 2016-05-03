<?php

namespace App\Repositories\Users;

interface UserRepositoryInterface
{

    public function index($columns);


    public function show($id, $columns = '*');
}