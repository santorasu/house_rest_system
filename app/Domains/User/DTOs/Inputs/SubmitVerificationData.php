<?php

namespace App\Domains\User\DTOs\Inputs;

use App\Domains\User\Enums\DocumentType;

class SubmitVerificationData
{
    public function __construct(
        public readonly DocumentType $document_type,
        public readonly string $document_path,
    ) {}

    public function toArray(): array
    {
        return [
            'document_type' => $this->document_type->value,
            'document_path' => $this->document_path,
        ];
    }
}
