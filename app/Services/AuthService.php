<?php

declare(strict_types=1);

namespace App\Services;

use App\Acme\Helpers\Mailer;
use App\Acme\Helpers\Str;
use App\Acme\JWT\JWT;
use App\Exceptions\GenericException;
use App\Repositories\Users\UserRepositoryInterface;

class AuthService
{
    /**
     * @var JWT
     */
    private $jwt;
    /**
     * @var UserRepositoryInterface
     */
    private $userRepository;

    /**
     * AuthService constructor.
     *
     * @param UserRepositoryInterface $userRepository
     * @param JWT $jwt
     */
    public function __construct(UserRepositoryInterface $userRepository, JWT $jwt)
    {
        $this->jwt = $jwt;
        $this->userRepository = $userRepository;
    }

    /**
     * @param array $input
     *
     * @return array
     *
     * @throws GenericException
     */
    public function login(array $input): array
    {
        if (!$user = $this->userRepository->getByEmail($input['email'])) {
            throw new GenericException('User not found', 'Invalid credentials', 404);
        }

        if (!password_verify($input['password'], $user['password'])) {
            throw new GenericException('User not found', 'Invalid credentials', 404);
        }

        return $user->toArray();
    }

    /**
     * Reset a User password
     *
     * @param array $input
     *
     * @return bool
     *
     * @throws GenericException
     */
    public function reset(array $input): bool
    {
        $password = password_hash($input['password'], PASSWORD_BCRYPT);

        if (!$user = $this->userRepository->getByEmailAndResetToken($input['email'], $input['token'])) {
            throw new GenericException('User not found', 'Password not updated', 404);
        }

        if (!$this->userRepository->update($user['id'], ['reset_password' => null, 'password' => $password])) {
            throw new GenericException('Error updating user', 'Password not updated', 500);
        }

        return true;
    }

    /**
     * Send an email for recovery User password
     *
     * @param string $email
     * @param Mailer $mailer
     *
     * @return void
     *
     * @throws GenericException
     */
    public function recovery(string $email, Mailer $mailer)
    {
        if (!$user = $this->userRepository->getByEmail($email)) {
            throw new GenericException('User not found', 'No user was found with this email', 404);
        }

        $token = Str::random(55);

        if (!$this->userRepository->update($user['id'], ['reset_password' => $token])) {
            throw new GenericException('Error updating user', 'A problem occurred trying to update the user', 500);
        }

        try {
            $mailer->send('Rest Password', [$email], 'Token is: ' . $token);
        } catch (\Exception $e) {
            throw new GenericException('Error sending the email', $e->getMessage(), 500);
        }
    }
}
