<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ForgotPasswordController;

Route::post('login', [AuthController::class, 'login']);
Route::post('register', [AuthController::class, 'register']);

Route::post('forgot-password', [ForgotPasswordController::class, 'sendOtp']);
Route::post('verify-otp', [ForgotPasswordController::class, 'verifyOtp']);
Route::post('reset-password', [ForgotPasswordController::class, 'resetPassword']);
// Route::middleware(['auth:sanctum', 'role:user|owner'])->group(function () {
//     Route::get('user-response', function () {
//         return response()->json([
//             'message' => 'User response',
//         ]);
//     });
// });


// Route::middleware(['auth:sanctum', 'role:owner'])->group(function () {
//     Route::get('owner-response', function () {
//         return response()->json([
//             'message' => 'Owner response',
//         ]);
//     });
// });



// Route::middleware(['auth:sanctum', 'role:admin'])->group(function () {
//      Route::get('admin-response', function () {
//         return response()->json([
//             'message' => 'Admin response',
//         ]);
//     });
// });