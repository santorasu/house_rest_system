<?php

namespace App\Domains\User\Policies;

use App\Domains\User\Models\Tenant;
use App\Models\User;

class TenantPolicy
{
    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Tenant $tenant): bool
    {
        return $user->id === $tenant->user_id || $user->id === $tenant->owner_id || $user->hasRole('admin');
    }

    /**
     * Determine whether the user can update the model (approve as active).
     */
    public function update(User $user, Tenant $tenant): bool
    {
        // Only the owner of the property can approve/manage the tenancy
        return $user->id === $tenant->owner_id;
    }
}
