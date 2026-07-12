<?php

namespace App\Domains\User\Controllers;

use App\Domains\User\Requests\UpdateProfileRequest;
use App\Domains\User\Resources\UserProfileResource;
use App\Domains\User\Services\UpdateProfileService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

/**
 * @tags User Profile
 */
class ProfileController extends Controller
{
    public function __construct(
        private UpdateProfileService $updateProfileService
    ) {}

    /**
     * Get Current User Profile
     *
     * Retrieves the profile information of the currently authenticated user.
     *
     * @response 200 {\App\Domains\User\Resources\UserProfileResource}
     * @response 404 {"message": "Profile not found"}
     */
    public function show(Request $request)
    {
        // For show, since we split the services, we'll fetch via Eloquent relation directly
        $profile = $request->user()->profile;

        if (! $profile) {
            return response()->json(['message' => 'Profile not found'], 404);
        }

        // We wrap the Eloquent model in the Response DTO to satisfy the resource
        $dto = \App\Domains\User\DTOs\Responses\UserProfileResponseData::fromModel($profile);

        return new UserProfileResource($dto);
    }

    /**
     * Update User Profile
     *
     * Updates the profile of the currently authenticated user.
     * Marks the profile as completed if both phone and address are provided.
     *
     * @response 200 {\App\Domains\User\Resources\UserProfileResource}
     */
    public function update(UpdateProfileRequest $request)
    {
        $responseDto = $this->updateProfileService->execute(
            $request->user()->id, 
            $request->toDTO()
        );

        return new UserProfileResource($responseDto);
    }
}
