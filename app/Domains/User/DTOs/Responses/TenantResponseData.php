<?php

namespace App\Domains\User\DTOs\Responses;

use App\Domains\User\Models\Tenant;

class TenantResponseData
{
    public function __construct(
        public readonly string $id,
        public readonly string $user_id,
        public readonly string $owner_id,
        public readonly string $property_id,
        public readonly string $status,
        public readonly string $lease_start_date,
        public readonly string $lease_end_date,
        public readonly string $created_at,
    ) {}

    public static function fromModel(Tenant $tenant): self
    {
        return new self(
            id: $tenant->id,
            user_id: $tenant->user_id,
            owner_id: $tenant->owner_id,
            property_id: $tenant->property_id,
            status: $tenant->status->value,
            lease_start_date: $tenant->lease_start_date->toDateString(),
            lease_end_date: $tenant->lease_end_date->toDateString(),
            created_at: $tenant->created_at->toIso8601String(),
        );
    }
}
