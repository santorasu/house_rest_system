<?php

namespace App\Domains\User\Policies;

use App\Domains\User\Models\UserProfile;
use App\Models\User;

class UserProfilePolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, UserProfile $userProfile): bool
    {
        return $user->id === $userProfile->user_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, UserProfile $userProfile): bool
    {
        return $user->id === $userProfile->user_id;
    }
}
