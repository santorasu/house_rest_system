<?php

namespace App\Domains\User\Enums;

enum DocumentType: string
{
    case PASSPORT = 'passport';
    case NATIONAL_ID = 'national_id';
    case DRIVING_LICENSE = 'driving_license';
    case PROPERTY_DEED = 'property_deed';
    case BUSINESS_LICENSE = 'business_license';

    /**
     * Get all available document type values.
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    /**
     * Get a human-readable label for the document type.
     */
    public function label(): string
    {
        return match($this) {
            self::PASSPORT => 'Passport',
            self::NATIONAL_ID => 'National ID',
            self::DRIVING_LICENSE => 'Driving License',
            self::PROPERTY_DEED => 'Property Deed',
            self::BUSINESS_LICENSE => 'Business License',
        };
    }
}
