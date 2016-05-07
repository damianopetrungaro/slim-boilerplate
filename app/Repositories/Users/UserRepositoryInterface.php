<?php

namespace App\Repositories\Users;

interface UserRepositoryInterface
{

    public function index($columns = '*');


    public function show($id, $columns = '*');


    public function store(array $data);


    public function update($id, array $data);


    public function delete($id);
}