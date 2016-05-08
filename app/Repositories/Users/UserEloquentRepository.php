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


    public function index($columns = [ '*' ])
    {
        return $this->model->get()->all($columns);
    }


    public function show($id, $columns = [ '*' ])
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
}