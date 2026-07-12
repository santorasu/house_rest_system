<?php

namespace App\Domains\User\Services;

use App\Domains\User\DTOs\Inputs\UpdateProfileData;
use App\Domains\User\DTOs\Responses\UserProfileResponseData;
use App\Domains\User\Events\UserProfileCompleted;
use App\Domains\User\Exceptions\ProfileUpdateException;
use App\Domains\User\Repositories\Interfaces\UserProfileRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Exception;

class UpdateProfileService
{
    public function __construct(
        private UserProfileRepositoryInterface $profileRepository
    ) {}

    public function execute(string $userId, UpdateProfileData $data): UserProfileResponseData
    {
        try {
            return DB::transaction(function () use ($userId, $data) {
                $profile = $this->profileRepository->updateOrCreate($userId, $data->toArray());

                if (!$profile->is_profile_completed && $profile->phone && $profile->address) {
                    $profile->is_profile_completed = true;
                    $profile->save();
                    event(new UserProfileCompleted($profile));
                }

                return UserProfileResponseData::fromModel($profile);
            });
        } catch (Exception $e) {
            throw new ProfileUpdateException("Failed to update profile: {$e->getMessage()}", 0, $e);
        }
    }
}
