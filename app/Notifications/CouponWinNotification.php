<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class CouponWinNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct($couponDetails)
    {
        $this->couponDetails = $couponDetails;
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
    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Congratulations! You’ve Won a Coupon')
                    ->greeting('Hello ' . $notifiable->name . ',')
                    ->line('We are excited to inform you that you have won a coupon.')
                    ->line('Coupon Title: ' . $this->couponDetails['title'])
                    ->line('Coupon Code: ' . $this->couponDetails['coupon_code'])
                    ->line('Coupon Description: ' . $this->couponDetails['description'])
                    ->line('Thank you for participating!')
                    //->action('View Your Coupon', url('/coupons/' . $this->couponDetails['coupon_code']))
                    ->line('Thank you for being with us!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray($notifiable)
    {
        return [
            'coupon_code' => $this->couponDetails['coupon_code'],
            'title' => $this->couponDetails['title'],
            'description' => $this->couponDetails['description'],
        ];
    }
}
