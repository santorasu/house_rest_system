<?php

namespace App\Domains\User\Services;

use App\Domains\User\DTOs\Inputs\RequestTenancyData;
use App\Domains\User\DTOs\Responses\TenantResponseData;
use App\Domains\User\Enums\TenantStatus;
use App\Domains\User\Events\TenantStatusChanged;
use App\Domains\User\Exceptions\TenancyConflictException;
use App\Domains\User\Exceptions\UnauthorizedTenancyActionException;
use App\Domains\User\Repositories\Interfaces\TenantRepositoryInterface;
use App\Domains\User\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Support\Facades\DB;

class TenantManagementService
{
    public function __construct(
        private TenantRepositoryInterface $tenantRepository,
        private UserRepositoryInterface $userRepository
    ) {}

    public function requestTenancy(string $userId, string $ownerId, RequestTenancyData $data): TenantResponseData
    {
        return DB::transaction(function () use ($userId, $ownerId, $data) {
            $existingTenancies = $this->tenantRepository->getByTenantId($userId);
            
            $hasConflict = $existingTenancies->contains(function ($tenant) use ($ownerId) {
                return $tenant->owner_id === $ownerId && in_array($tenant->status, [TenantStatus::PENDING, TenantStatus::ACTIVE]);
            });

            if ($hasConflict) {
                throw new TenancyConflictException('You already have an active or pending tenancy with this owner.');
            }

            $leaseDetails = $data->toArray();
            $leaseDetails['user_id'] = $userId;
            $leaseDetails['owner_id'] = $ownerId;
            $leaseDetails['status'] = TenantStatus::PENDING;

            $tenant = $this->tenantRepository->create($leaseDetails);

            return TenantResponseData::fromModel($tenant);
        });
    }

    public function approveTenancy(string $tenantId, string $ownerId): bool
    {
        return DB::transaction(function () use ($tenantId, $ownerId) {
            $tenant = $this->tenantRepository->findById($tenantId);

            if (!$tenant || $tenant->owner_id !== $ownerId) {
                throw new UnauthorizedTenancyActionException('You are not authorized to approve this tenancy.');
            }

            $success = $this->tenantRepository->updateStatus($tenantId, TenantStatus::ACTIVE);

            if ($success) {
                event(new TenantStatusChanged($tenant));
            }

            return $success;
        });
    }

    public function evictTenant(string $tenantId, string $ownerId): bool
    {
        return DB::transaction(function () use ($tenantId, $ownerId) {
            $tenant = $this->tenantRepository->findById($tenantId);

            if (!$tenant || $tenant->owner_id !== $ownerId) {
                throw new UnauthorizedTenancyActionException('You are not authorized to evict this tenant.');
            }

            $success = $this->tenantRepository->updateStatus($tenantId, TenantStatus::EVICTED);

            if ($success) {
                event(new TenantStatusChanged($tenant));
            }

            return $success;
        });
    }
}
