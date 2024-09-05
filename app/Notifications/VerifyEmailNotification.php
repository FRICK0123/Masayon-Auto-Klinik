<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class VerifyEmailNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */

    public $customer;
    public function __construct($customer)
    {
        $this->customer = $customer;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = url('/verify-email/' . $this->customer->verification_token);
        return (new MailMessage)
            ->subject('Verify Your Email Address')
            ->line('Click the button below to verify your email address.')
            ->action('Verify Email Address', $url)
            ->line('Thank you for registering with us!')
            ->salutation('Best regards, Masayon Auto Klinik');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
