<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\HtmlString;

class ProfileApproved extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
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
            ->subject('Cherry21 You are Online')
            ->line(new HtmlString("<div style=\"text-align: center;\">Hi there,</div>"))
            ->line(new HtmlString("<div style=\"text-align: center;\">Congratulations!</div>"))
            ->line(new HtmlString("<div style=\"text-align: center;\">Your profile has been approved, and you are Online.</div>"))
            ->action('Go to site', url('/'))
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
