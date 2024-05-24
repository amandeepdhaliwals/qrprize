<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ClaimRequestNotification extends Notification
{
    use Queueable;

    private $name;
    private $address;
    private $code;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($name, $address, $code)
    {
        $this->name = $name;
        $this->address = $address;
        $this->code = $code;
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
        ->subject('New Claim Request')
        ->line('A new claim request has been submitted by a customer.')
        ->line('Customer Name: ' . $this->name)
        ->line('Customer Address: ' . $this->address)
        ->line('Coupon Code: ' . $this->code);
    
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'name' => $this->name,
            'address' => $this->address,
            'code' => $this->code,
        ];
    }
}
