<?php

namespace App\Domains\User\Services;

use App\Domains\User\Enums\UserRole;
use App\Domains\User\Enums\VerificationStatus;
use App\Domains\User\Exceptions\UnverifiedUserException;
use App\Domains\User\Repositories\Interfaces\UserRepositoryInterface;
use App\Domains\User\Repositories\Interfaces\UserVerificationRepositoryInterface;

class UserRoleManagementService
{
    public function __construct(
        private UserRepositoryInterface $userRepository,
        private UserVerificationRepositoryInterface $verificationRepository
    ) {}

    public function upgradeToOwner(string $userId, string $adminId): void
    {
        $verifications = $this->verificationRepository->getByUserId($userId);

        $hasApprovedKyc = $verifications->contains('status', VerificationStatus::APPROVED);

        if (!$hasApprovedKyc) {
            throw new UnverifiedUserException('User must have an approved KYC document to become an Owner.');
        }

        $user = $this->userRepository->findById($userId);
        
        if ($user) {
            $this->userRepository->assignRole($user, UserRole::OWNER->value);
        }
    }
}
