<?php

namespace App\Domains\User\Repositories\Interfaces;

use App\Domains\User\Enums\TenantStatus;
use App\Domains\User\Models\Tenant;
use Illuminate\Database\Eloquent\Collection;

interface TenantRepositoryInterface
{
    public function findById(string $id): ?Tenant;

    public function getByTenantId(string $userId): Collection;

    public function getByOwnerId(string $ownerId, ?TenantStatus $status = null): Collection;

    public function create(array $data): Tenant;

    public function updateStatus(string $id, TenantStatus $status): bool;
}
