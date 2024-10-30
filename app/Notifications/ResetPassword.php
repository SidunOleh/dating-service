<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class ResetPassword extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(
        public string $url
    )
    {
        //
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
        return (new MailMessage)
                    ->subject('Cherry21 Reset Password ')
                    ->line(new HtmlString("<div style=\"text-align: center;\">You’re receiving this email because we got a request to reset your password.</div>"))
                    ->line(new HtmlString("<div style=\"text-align: center;\">Click the link below to reset your password.</div>"))
                    ->action('Reset Password', $this->url)
                    ->line(new HtmlString("<div style=\"text-align: center;\">This link will expire in <b>60 minutes</b>.</div>"));
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
