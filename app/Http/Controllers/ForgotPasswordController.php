<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Dedoc\Scramble\Attributes\Group;

#[Group('Auth')]
class ForgotPasswordController extends Controller
{
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $email = $request->email;
        // Generate a 4-digit OTP
        $otp = str_pad(random_int(0, 9999), 4, '0', STR_PAD_LEFT);

        // Store the hashed OTP in the database
        DB::table('password_reset_tokens')->updateOrInsert(
            ['email' => $email],
            [
                'token' => Hash::make($otp),
                'created_at' => now(),
            ]
        );

        // In a real application, send the OTP via email here.
        // We log it so you can see it while developing.
        Log::info("OTP for {$email} is: {$otp}");

        return response()->json([
            'message' => 'OTP sent to your email successfully.',
            // For testing purposes, we return it. Remove this in production!
            'test_otp' => $otp, 
        ]);
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|digits:4',
        ]);

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        // Verify the OTP
        if (!$resetRecord || !Hash::check($request->otp, $resetRecord->token)) {
            return response()->json([
                'message' => 'Invalid OTP.',
            ], 400);
        }

        // Check if OTP has expired (e.g., valid for 15 minutes)
        if (now()->subMinutes(15)->gt($resetRecord->created_at)) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return response()->json([
                'message' => 'OTP has expired.',
            ], 400);
        }

        return response()->json([
            'message' => 'OTP verified successfully. You can now reset your password.',
        ]);
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
            'otp' => 'required|digits:4',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $resetRecord = DB::table('password_reset_tokens')
            ->where('email', $request->email)
            ->first();

        // Verify the OTP
        if (!$resetRecord || !Hash::check($request->otp, $resetRecord->token)) {
            return response()->json([
                'message' => 'Invalid OTP.',
            ], 400);
        }

        // Check if OTP has expired (e.g., valid for 15 minutes)
        if (now()->subMinutes(15)->gt($resetRecord->created_at)) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return response()->json([
                'message' => 'OTP has expired.',
            ], 400);
        }

        // Update the user's password
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->password);
        $user->save();

        // Delete the OTP record after successful reset
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return response()->json([
            'message' => 'Password reset successfully.',
        ]);
    }
}
