<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class VerificationCode extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private int $code)
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
                    ->subject('Cherry21 Verification Code')
                    ->line(new HtmlString("<div style=\"text-align: center;\">Verification code:</div>"))
                    ->line(new HtmlString("<div style=\"text-align: center; font-size: 50px; color: #000;\">{$this->code}</div>"))
                    ->action('Go to Site', url('/'))
                    ->line(new HtmlString("<div style=\"text-align: center;\">This code will expire in <b>10 minutes</b>.</div>"));
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
