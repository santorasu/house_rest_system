<?php

namespace App\Domains\User\DTOs\Inputs;

use App\Domains\User\Enums\VerificationStatus;

class ReviewVerificationData
{
    public function __construct(
        public readonly string $reviewer_id,
        public readonly VerificationStatus $status,
        public readonly ?string $rejection_reason = null,
    ) {}
}
