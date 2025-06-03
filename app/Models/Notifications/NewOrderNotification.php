<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use App\Models\Order;

class NewOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $order;

    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $url = route('orders.show', $this->order->id);

        return (new MailMessage)
            ->subject('Pesanan Baru #' . $this->order->id)
            ->greeting('Halo Admin!')
            ->line('Ada pesanan baru yang perlu diproses.')
            ->line('Detail Pesanan:')
            ->line('- Order ID: #' . $this->order->id)
            ->line('- Pembeli: ' . $this->order->user_name)
            ->line('- Total: Rp' . number_format($this->order->total, 0, ',', '.'))
            ->action('Lihat Detail Pesanan', $url)
            ->line('Terima kasih telah menggunakan aplikasi kami!');
    }
} 