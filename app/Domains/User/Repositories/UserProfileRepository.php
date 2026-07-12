<?php

namespace App\Domains\User\Repositories;

use App\Domains\User\Models\UserProfile;
use App\Domains\User\Repositories\Interfaces\UserProfileRepositoryInterface;

class UserProfileRepository implements UserProfileRepositoryInterface
{
    public function findByUserId(string $userId): ?UserProfile
    {
        return UserProfile::where('user_id', $userId)->first();
    }

    public function updateOrCreate(string $userId, array $data): UserProfile
    {
        return UserProfile::updateOrCreate(
            ['user_id' => $userId],
            $data
        );
    }
}
