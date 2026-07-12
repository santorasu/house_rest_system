<?php

namespace App\Domains\User\Events;

use App\Domains\User\Models\UserProfile;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserProfileCompleted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public UserProfile $profile
    ) {}
}
