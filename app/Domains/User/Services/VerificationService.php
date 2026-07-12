<?php

namespace App\Domains\User\Services;

use App\Domains\User\DTOs\Inputs\ReviewVerificationData;
use App\Domains\User\DTOs\Inputs\SubmitVerificationData;
use App\Domains\User\DTOs\Responses\VerificationResponseData;
use App\Domains\User\Enums\VerificationStatus;
use App\Domains\User\Events\VerificationStatusChanged;
use App\Domains\User\Events\VerificationSubmitted;
use App\Domains\User\Exceptions\DuplicateVerificationException;
use App\Domains\User\Exceptions\InvalidReviewException;
use App\Domains\User\Repositories\Interfaces\UserVerificationRepositoryInterface;
use Illuminate\Support\Facades\DB;

class VerificationService
{
    public function __construct(
        private UserVerificationRepositoryInterface $verificationRepository
    ) {}

    public function submitDocument(string $userId, SubmitVerificationData $data): VerificationResponseData
    {
        return DB::transaction(function () use ($userId, $data) {
            $existing = $this->verificationRepository->getByUserId($userId);
            
            if ($existing->contains('status', VerificationStatus::PENDING)) {
                throw new DuplicateVerificationException('A pending verification already exists.');
            }

            $documentData = $data->toArray();
            $documentData['user_id'] = $userId;
            $documentData['status'] = VerificationStatus::PENDING;

            $verification = $this->verificationRepository->create($documentData);

            event(new VerificationSubmitted($verification));

            return VerificationResponseData::fromModel($verification);
        });
    }

    public function reviewDocument(string $verificationId, ReviewVerificationData $data): bool
    {
        if ($data->status === VerificationStatus::REJECTED && empty($data->rejection_reason)) {
            throw new InvalidReviewException('A rejection reason must be provided when rejecting a verification.');
        }

        return DB::transaction(function () use ($verificationId, $data) {
            $success = $this->verificationRepository->updateStatus(
                $verificationId, 
                $data->status, 
                $data->reviewer_id, 
                $data->rejection_reason
            );
            
            if ($success) {
                $verification = $this->verificationRepository->findById($verificationId);
                event(new VerificationStatusChanged($verification));
            }

            return $success;
        });
    }
}
