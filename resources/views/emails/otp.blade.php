<x-mail::message>
# Password Reset Request

We received a request to reset your password. Use the OTP below to proceed.

<x-mail::panel>
# {{ $otp }}
</x-mail::panel>

If you did not request a password reset, no further action is required.

Thanks,<br>
{{ config('app.name') }}
</x-mail::message>
