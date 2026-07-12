<?php

namespace App\Domains\User\Models;

use App\Domains\User\Enums\DocumentType;
use App\Domains\User\Enums\VerificationStatus;
use App\Models\User;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserVerification extends Model
{
    use HasUuids;

    protected $fillable = [
        'user_id',
        'document_type',
        'document_path',
        'status',
        'rejection_reason',
        'verified_at',
        'reviewed_by',
    ];

    protected $casts = [
        'verified_at' => 'datetime',
        'status' => VerificationStatus::class,
        'document_type' => DocumentType::class,
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    /**
     * Scope a query to only include pending verifications.
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope a query to only include approved verifications.
     */
    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }
}
