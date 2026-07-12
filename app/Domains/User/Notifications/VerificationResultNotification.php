<?php

namespace App\Domains\User\Notifications;

use App\Domains\User\Models\UserVerification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerificationResultNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public UserVerification $verification
    ) {}

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $message = (new MailMessage)
            ->subject('Identity Verification Result')
            ->line('Your identity verification request has been updated.');

        if ($this->verification->status === 'approved') {
            $message->line('Congratulations! Your document has been approved.');
        } else {
            $message->line('Unfortunately, your document was rejected.');
            if ($this->verification->rejection_reason) {
                $message->line('Reason: '.$this->verification->rejection_reason);
            }
        }

        return $message;
    }
}
