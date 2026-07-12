<?php

namespace App\Domains\User\DTOs\Inputs;

class RequestTenancyData
{
    public function __construct(
        public readonly string $property_id,
        public readonly string $lease_start_date,
        public readonly string $lease_end_date,
    ) {}

    public function toArray(): array
    {
        return [
            'property_id' => $this->property_id,
            'lease_start_date' => $this->lease_start_date,
            'lease_end_date' => $this->lease_end_date,
        ];
    }
}
