<?php

namespace App\Notifications;

// use Illuminate\Bus\Queueable;
// use Illuminate\Contracts\Queue\ShouldQueue;
// use Illuminate\Notifications\Messages\MailMessage;
// use Illuminate\Notifications\Notification;

use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\DatabaseMessage;
use Illuminate\Notifications\Messages\FcmMessage;

class MobileAppNotification extends Notification
{
    protected $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    // Specify delivery channels
    public function via($notifiable)
    {
        $via = ['database'];
        if ($notifiable->push_notifications_enabled && $notifiable->device_token) {
            // $via[] = 'fcm';
        }

        if ($notifiable->email_notifications_enabled) {
            $via[] = 'mail';
        }

        return $via;
    }

    // Define Database notification structure
    public function toDatabase($notifiable)
    {
        return [
            'title' => $this->data['title'],
            'body' => $this->data['body'],
            'additional_data' => $this->data['additional_data'] ?? [],
        ];
    }

    // Define FCM notification structure
    public function toFcm($notifiable)
    {
        return (new FcmMessage())
            ->title($this->data['title'])
            ->body($this->data['body'])
            ->data($this->data['additional_data'] ?? [])
            ->token($notifiable->device_token);
    }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject($this->data['title'])
            ->line($this->data['body'])
            // ->action('View Notification', $this->data['additional_data']['url'] ?? url('/'))
            ->line('Thank you for using QR Prize!');
    }
}
