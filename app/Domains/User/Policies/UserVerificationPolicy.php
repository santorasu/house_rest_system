<?php

namespace App\Domains\User\Policies;

use App\Domains\User\Models\UserVerification;
use App\Models\User;

class UserVerificationPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, UserVerification $verification): bool
    {
        return $user->id === $verification->user_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return true; // Any authenticated user can submit a verification
    }

    /**
     * Determine whether the user can update the model (approve/reject).
     */
    public function update(User $user, UserVerification $verification): bool
    {
        return $user->hasRole('admin');
    }
}
