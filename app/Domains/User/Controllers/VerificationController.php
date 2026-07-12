<?php

namespace App\Domains\User\Controllers;

use App\Domains\User\Requests\SubmitVerificationRequest;
use App\Domains\User\Resources\UserVerificationResource;
use App\Domains\User\Services\VerificationService;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function __construct(
        private VerificationService $verificationService
    ) {}

    public function index(Request $request)
    {
        $verifications = $request->user()->verifications;

        return UserVerificationResource::collection($verifications);
    }

    public function store(SubmitVerificationRequest $request)
    {
        $verification = $this->verificationService->submitVerification(
            $request->user()->id,
            $request->validated('document_type'),
            $request->file('document')
        );

        return new UserVerificationResource($verification);
    }
}
