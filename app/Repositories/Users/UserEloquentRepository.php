<?php
namespace App\Repositories\Users;

use App\Models\User;

class UserEloquentRepository implements UserRepositoryInterface
{

	protected $model;


	public function __construct(User $model)
	{
		$this->model = $model;
	}


	public function index($columns = ['*'])
	{
		return $this->model->get()->all($columns);
	}


	public function show($id, $columns = ['*'])
	{
		return $this->model->find($id, $columns);
	}


	public function store(array $data)
	{
		return $this->model->create($data);
	}


	public function update($id, array $data)
	{
		return $this->model->where('id', $id)->update($data);
	}


	public function delete($id)
	{
		return $this->model->where('id', $id)->delete();
	}


	public function getByEmailAndPassword($email, $password, $columns = ['*'])
	{
		return $this->model->where('email', $email)->where('password', $password)->first($columns);
	}


	public function getByEmail($email, $columns = ['*'])
	{
		return $this->model->where('email', $email)->first($columns);
	}


	public function getByEmailAndResetToken($email, $token, $columns = ['*'])
	{
		return $this->model->where('email', $email)->where('reset_password', $token)->first($columns);
	}
}