<?php

use App\Domains\User\Controllers\AdminVerificationController;
use App\Domains\User\Controllers\ProfileController;
use App\Domains\User\Controllers\TenantController;
use App\Domains\User\Controllers\VerificationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ForgotPasswordController;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::post('forgot-password', [ForgotPasswordController::class, 'sendOtp']);
Route::post('verify-otp', [ForgotPasswordController::class, 'verifyOtp']);
Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword']);
Route::middleware('auth:sanctum')->group(function () {

    // User Profile
    Route::get('/user/profile', [ProfileController::class, 'show']);
    Route::post('/user/profile', [ProfileController::class, 'update']);

    // User Verification
    Route::get('/user/verifications', [VerificationController::class, 'index']);
    Route::post('/user/verifications', [VerificationController::class, 'store']);

    // Tenancy
    Route::get('/user/tenancies', [TenantController::class, 'index']);
    Route::post('/user/tenancies', [TenantController::class, 'store']);

});

Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
    // Admin Verification Management
    Route::get('/admin/verifications', [AdminVerificationController::class, 'index']);
    Route::post('/admin/verifications/{id}', [AdminVerificationController::class, 'update']);
});
