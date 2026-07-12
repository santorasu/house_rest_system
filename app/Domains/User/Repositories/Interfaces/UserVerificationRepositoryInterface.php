<?php

namespace App\Domains\User\Repositories\Interfaces;

use App\Domains\User\Enums\VerificationStatus;
use App\Domains\User\Models\UserVerification;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface UserVerificationRepositoryInterface
{
    public function findById(string $id): ?UserVerification;

    public function getByUserId(string $userId): Collection;

    public function getPaginatedByStatus(VerificationStatus $status, int $perPage = 15): LengthAwarePaginator;

    public function create(array $data): UserVerification;

    public function updateStatus(string $id, VerificationStatus $status, string $reviewerId, ?string $rejectionReason = null): bool;
}
