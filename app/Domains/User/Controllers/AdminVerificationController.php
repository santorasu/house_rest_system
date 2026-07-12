<?php

namespace App\Domains\User\Controllers;

use App\Domains\User\Repositories\Interfaces\UserVerificationRepositoryInterface;
use App\Domains\User\Requests\ProcessVerificationRequest;
use App\Domains\User\Resources\UserVerificationResource;
use App\Domains\User\Services\VerificationService;
use App\Http\Controllers\Controller;

class AdminVerificationController extends Controller
{
    public function __construct(
        private VerificationService $verificationService,
        private UserVerificationRepositoryInterface $verificationRepository
    ) {}

    public function index()
    {
        // Require admin role
        if (! auth()->user()->hasRole('admin')) {
            abort(403);
        }

        $pending = $this->verificationRepository->getPending();

        return UserVerificationResource::collection($pending);
    }

    public function update(ProcessVerificationRequest $request, int $id)
    {
        $success = $this->verificationService->processVerification(
            $id,
            $request->validated('status'),
            $request->validated('rejection_reason')
        );

        if (! $success) {
            return response()->json(['message' => 'Verification not found or failed to process'], 400);
        }

        return response()->json(['message' => 'Verification processed successfully']);
    }
}
