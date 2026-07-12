<?php

namespace App\Domains\User\Repositories;

use App\Domains\User\Enums\TenantStatus;
use App\Domains\User\Models\Tenant;
use App\Domains\User\Repositories\Interfaces\TenantRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TenantRepository implements TenantRepositoryInterface
{
    public function findById(string $id): ?Tenant
    {
        return Tenant::find($id);
    }

    public function getByTenantId(string $userId): Collection
    {
        return Tenant::with('owner')
            ->where('user_id', $userId)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function getByOwnerId(string $ownerId, ?TenantStatus $status = null): Collection
    {
        $query = Tenant::with('user')->where('owner_id', $ownerId);

        if ($status) {
            $query->where('status', $status);
        }

        return $query->orderBy('created_at', 'desc')->get();
    }

    public function create(array $data): Tenant
    {
        return Tenant::create($data);
    }

    public function updateStatus(string $id, TenantStatus $status): bool
    {
        $tenant = $this->findById($id);

        if (!$tenant) {
            return false;
        }

        return $tenant->update(['status' => $status]);
    }
}
