<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public Order $order)
    {
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Your Order #' . $this->order->id . ' Has Been Received')
            ->line('Thank you for your order!')
            ->line('Order Total: $' . number_format($this->order->total_price, 2))
            ->action('View Order', url('/orders/' . $this->order->id))
            ->line('We will notify you when your order ships.');
    }

    public function toArray($notifiable)
    {
        return [
            'order_id' => $this->order->id,
            'total' => $this->order->total_price,
        ];
    }
}