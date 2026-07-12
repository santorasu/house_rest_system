<?php

namespace App\Domains\User\DTOs\Inputs;

class UpdateProfileData
{
    public function __construct(
        public readonly ?string $phone = null,
        public readonly ?string $address = null,
        public readonly ?string $avatar_url = null,
        public readonly ?string $emergency_contact_name = null,
        public readonly ?string $emergency_contact_phone = null,
    ) {}

    public function toArray(): array
    {
        return array_filter([
            'phone' => $this->phone,
            'address' => $this->address,
            'avatar_url' => $this->avatar_url,
            'emergency_contact_name' => $this->emergency_contact_name,
            'emergency_contact_phone' => $this->emergency_contact_phone,
        ], fn ($value) => !is_null($value));
    }
}
