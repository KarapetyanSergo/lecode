<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserNewsNotification extends Notification
{
    use Queueable;

    private string $title;
    private string $text;

    public function __construct(string $title, string $text)
    {
        $this->title = $title;
        $this->text = $text;
    }

    public function via($notifiable)
    {
        return ['database'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('/'))
                    ->line('Thank you for using our application!');
    }

    public function toArray($notifiable)
    {
        return [
            'title' => $this->title,
            'text' => $this->text,
        ];
    }
}
