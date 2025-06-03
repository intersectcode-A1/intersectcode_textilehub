<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class NewOrderNotification extends Notification
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Pesanan Baru - #' . $this->order->id)
            ->greeting('Halo Admin!')
            ->line('Ada pesanan baru yang perlu diproses.')
            ->line('Detail Pesanan:')
            ->line('Nama: ' . $this->order->user_name)
            ->line('Email: ' . $this->order->email)
            ->line('Total: Rp ' . number_format($this->order->total, 0, ',', '.'))
            ->action('Lihat Pesanan', route('orders.show', $this->order->id))
            ->line('Terima kasih telah menggunakan aplikasi kami!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order_id' => $this->order->id,
            'user_name' => $this->order->user_name,
            'email' => $this->order->email,
            'total' => $this->order->total,
            'status' => $this->order->status,
        ];
    }
} 