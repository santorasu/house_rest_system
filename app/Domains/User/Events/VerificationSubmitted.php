<?php

namespace App\Domains\User\Events;

use App\Domains\User\Models\UserVerification;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VerificationSubmitted
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public function __construct(
        public UserVerification $verification
    ) {}
}
