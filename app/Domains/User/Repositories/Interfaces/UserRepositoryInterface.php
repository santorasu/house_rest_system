<?php

namespace App\Domains\User\Repositories\Interfaces;

use App\Models\User;

interface UserRepositoryInterface
{
    public function findById(string $id): ?User;

    public function findByEmail(string $email): ?User;

    public function create(array $data): User;

    public function update(string $id, array $data): bool;

    public function assignRole(User $user, string $role): void;
}
