<?php

namespace App\Services;

use App\Acme\Helpers\Str;
use App\Acme\Helpers\Mailer;
use App\Acme\JWT\Manager as JWT;
use App\Exceptions\GenericException;
use App\Repositories\Users\UserRepositoryInterface;

class AuthService
{
    private $userRepository;
    private $jwt;

    public function __construct(UserRepositoryInterface $userRepository, JWT $jwt)
    {
        $this->userRepository = $userRepository;
        $this->jwt = $jwt;
    }

    public function login(array $input)
    {
        $email = $input['email'];
        $password = md5($input['password']); // Hash password (better if you use a key for hash)

        if (!$user = $this->userRepository->getByEmailAndPassword($email, $password)) {
            throw new GenericException('User not found', 'Invalid credentials', 404);
        }

        return $user->toArray();
    }

    public function reset(array $input)
    {
        $email = $input['email'];
        $token = $input['token'];
        $password = md5($input['password']);

        if (!$user = $this->userRepository->getByEmailAndResetToken($email, $token)) {
            throw new GenericException('User not found', 'Password not updated', 404);
        }

        if (!$this->userRepository->update($user['id'], ['reset_password' => '', 'password' => $password])) {
            throw new GenericException('Error updating user', 'Password not updated', 500);
        }

        return true;
    }

    public function recovery($email)
    {
        if (!$user = $this->userRepository->getByEmail($email)) {
            throw new GenericException('User not found', 'No user was found with this email', 404);
        }

        $token = Str::random(55);

        if (!$this->userRepository->update($user['id'], ['reset_password' => $token])) {
            throw new GenericException('Error updating user', 'A problem occurred trying to update the user', 500);
        }

        try {
            Mailer::send('Rest Password', [$email], 'Token is: ' . $token);
        } catch (\Exception $e) {
            throw new GenericException('Error sending the email', $e->getMessage(), 500);
        }
    }
}
