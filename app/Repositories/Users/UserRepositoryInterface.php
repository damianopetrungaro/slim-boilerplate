<?php

namespace App\Repositories\Users;

interface UserRepositoryInterface
{
	public function delete($id);

	public function store(array $data);

	public function index($columns = '*');

	public function update($id, array $data);

	public function show($id, $columns = '*');

	public function getByEmail($email);

	public function getByEmailAndPassword($email, $password);

	public function getByEmailAndResetToken($email, $token);
}