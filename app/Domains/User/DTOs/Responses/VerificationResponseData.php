<?php

namespace App\Domains\User\DTOs\Responses;

use App\Domains\User\Models\UserVerification;

class VerificationResponseData
{
    public function __construct(
        public readonly string $id,
        public readonly string $user_id,
        public readonly string $document_type,
        public readonly string $status,
        public readonly ?string $rejection_reason,
        public readonly string $created_at,
        public readonly ?string $verified_at,
    ) {}

    public static function fromModel(UserVerification $verification): self
    {
        return new self(
            id: $verification->id,
            user_id: $verification->user_id,
            document_type: $verification->document_type->value,
            status: $verification->status->value,
            rejection_reason: $verification->rejection_reason,
            created_at: $verification->created_at->toIso8601String(),
            verified_at: $verification->verified_at?->toIso8601String(),
        );
    }
}
