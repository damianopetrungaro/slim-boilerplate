<?php

declare(strict_types=1);

namespace App\Repositories\Users;

use App\Models\User;

interface UserRepositoryInterface
{
    public function delete(int $id): bool;

    public function store(array $data):? User;

    public function index(): array;

    public function update(int $id, array $data): bool;

    public function show(int $id):? User;

    public function getByEmail(string $email):? User;

    public function getByEmailAndResetToken(string $email, string $token):? User;
}
