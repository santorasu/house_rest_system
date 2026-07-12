<?php

namespace App\Domains\User\Repositories\Interfaces;

use App\Domains\User\Models\UserProfile;

interface UserProfileRepositoryInterface
{
    public function findByUserId(string $userId): ?UserProfile;

    public function updateOrCreate(string $userId, array $data): UserProfile;
}
