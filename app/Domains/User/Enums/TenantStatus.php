<?php

namespace App\Domains\User\Enums;

enum TenantStatus: string
{
    case PENDING = 'pending';
    case ACTIVE = 'active';
    case PAST = 'past';
    case EVICTED = 'evicted';

    /**
     * Get all available status values.
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Check if the tenant is active.
     */
    public function isActive(): bool
    {
        return $this === self::ACTIVE;
    }
}
