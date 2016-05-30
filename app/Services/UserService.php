<?php

namespace App\Services;

use App\Repositories\Users\UserRepositoryInterface;

class UserService
{
    private $userRepository;

    public function __construct(UserRepositoryInterface $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function store(array $input)
    {
        $data = [];
        $data['password'] = md5($input['password']); // Hash password (better if you use a key for hash)
        $data['name'] = $input['name'];
        $data['surname'] = $input['surname'];
        $data['email'] = $input['email'];
        $user = $this->userRepository->store($data);

        return $user;
    }

    public function update($id, array $input)
    {
        $data = [];
        $data['name'] = $input['name'];
        $data['surname'] = $input['surname'];
        $user = $this->userRepository->update($id, $data);

        return $user;
    }
}
