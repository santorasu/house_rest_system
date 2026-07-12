<?php

namespace App\Domains\User\Repositories;

use App\Domains\User\Enums\VerificationStatus;
use App\Domains\User\Models\UserVerification;
use App\Domains\User\Repositories\Interfaces\UserVerificationRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class UserVerificationRepository implements UserVerificationRepositoryInterface
{
    public function findById(string $id): ?UserVerification
    {
        return UserVerification::find($id);
    }

    public function getByUserId(string $userId): Collection
    {
        return UserVerification::where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getPaginatedByStatus(VerificationStatus $status, int $perPage = 15): LengthAwarePaginator
    {
        return UserVerification::with('user')
            ->where('status', $status)
            ->orderBy('created_at', 'asc')
            ->paginate($perPage);
    }

    public function create(array $data): UserVerification
    {
        return UserVerification::create($data);
    }

    public function updateStatus(string $id, VerificationStatus $status, string $reviewerId, ?string $rejectionReason = null): bool
    {
        $verification = $this->findById($id);

        if (!$verification) {
            return false;
        }

        $data = [
            'status' => $status,
            'reviewed_by' => $reviewerId,
            'rejection_reason' => $rejectionReason,
        ];

        if ($status === VerificationStatus::APPROVED) {
            $data['verified_at'] = now();
        }

        return $verification->update($data);
    }
}
