<?php

namespace App\Domains\User\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case OWNER = 'owner';
    case USER = 'user';

    /**
     * Get all available role values.
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get a human-readable label for the role.
     */
    public function label(): string
    {
        return match($this) {
            self::ADMIN => 'System Administrator',
            self::OWNER => 'Property Owner',
            self::USER => 'Regular User',
        };
    }
}
