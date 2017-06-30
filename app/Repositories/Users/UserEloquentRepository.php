<?php

declare(strict_types=1);

namespace App\Repositories\Users;

use App\Models\User;

class UserEloquentRepository implements UserRepositoryInterface
{
    /**
     * @var User
     */
    protected $model;

    /**
     * UserEloquentRepository constructor.
     *
     * !!!!!!!!!!!!!!!
     * NOTE: Use Query Builder is a better approach instead of using a Model with active record
     * !!!!!!!!!!!!!!!
     *
     * @param User $model
     */
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * List all the Users
     *
     * @return array
     */
    public function index(): array
    {
        return $this->model->get()->all();
    }


    /**
     * Get a specific User
     *
     * @param int $id
     *
     * @return User|null
     */
    public function show(int $id):? User
    {
        $user = $this->model->find($id);

        return $this->returnUserInstanceOrNull($user);
    }

    /**
     * Add a new User
     *
     * @param array $data
     *
     * @return User|null
     */
    public function store(array $data):? User
    {
        $user = $this->model->create($data);

        return $this->returnUserInstanceOrNull($user);
    }

    /**
     * Update data of a specific User
     *
     * @param int $id
     * @param array $data
     *
     * @return bool
     */
    public function update(int $id, array $data): bool
    {
        return (bool)$this->model->where('id', $id)->update($data);
    }

    /**
     * Delete an User
     *
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool
    {
        return (bool)$this->model->where('id', $id)->delete();
    }

    /**
     * Get a user by email
     *
     * @param string $email
     *
     * @return User|null
     */
    public function getByEmail(string $email):?User
    {
        $user = $this->model->where('email', $email)->first();

        return $this->returnUserInstanceOrNull($user);
    }

    /**
     * Return an user by email and a token
     *
     * @param string $email
     * @param string $token
     *
     * @return User|null
     */
    public function getByEmailAndResetToken(string $email, string $token):? User
    {
        $user = $this->model->where('email', $email)->where('reset_password', $token)->first();

        return $this->returnUserInstanceOrNull($user);
    }

    /**
     * Return User instance or null
     *
     * @param $user
     *
     * @return User|null
     */
    private function returnUserInstanceOrNull($user):? User
    {
        if ($user instanceof User) {

            return $user;
        }

        return null;
    }
}
