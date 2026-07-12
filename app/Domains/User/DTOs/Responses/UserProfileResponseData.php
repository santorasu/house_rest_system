<?php

namespace App\Domains\User\DTOs\Responses;

use App\Domains\User\Models\UserProfile;

class UserProfileResponseData
{
    public function __construct(
        public readonly string $id,
        public readonly string $user_id,
        public readonly ?string $phone,
        public readonly ?string $address,
        public readonly ?string $avatar_url,
        public readonly ?string $emergency_contact_name,
        public readonly ?string $emergency_contact_phone,
        public readonly bool $is_profile_completed,
        public readonly string $created_at,
    ) {}

    public static function fromModel(UserProfile $profile): self
    {
        return new self(
            id: $profile->id,
            user_id: $profile->user_id,
            phone: $profile->phone,
            address: $profile->address,
            avatar_url: $profile->avatar_url,
            emergency_contact_name: $profile->emergency_contact_name,
            emergency_contact_phone: $profile->emergency_contact_phone,
            is_profile_completed: (bool) $profile->is_profile_completed,
            created_at: $profile->created_at->toIso8601String(),
        );
    }
}
