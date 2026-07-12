<?php

namespace App\Domains\User\Models;

use App\Domains\User\Enums\TenantStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tenant extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'owner_id',
        'property_id',
        'status',
        'lease_start_date',
        'lease_end_date',
    ];

    protected $casts = [
        'lease_start_date' => 'date',
        'lease_end_date' => 'date',
        'status' => TenantStatus::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    /**
     * Scope a query to only include pending tenancies.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include active tenancies.
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }
}
