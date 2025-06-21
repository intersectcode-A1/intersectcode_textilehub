<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;

class NotificationController extends Controller
{
    /**
     * Tandai notifikasi sebagai sudah dibaca dan arahkan ke tujuan.
     */
    public function markAsRead(DatabaseNotification $notification)
    {
        // Pastikan notifikasi milik user yang sedang login
        if (Auth::id() !== $notification->notifiable_id) {
            abort(403);
        }

        $notification->markAsRead();

        // Arahkan ke halaman detail pesanan
        $orderId = $notification->data['order_id'];
        return redirect()->route('orders.show', $orderId);
    }

    /**
     * Tandai semua notifikasi sebagai sudah dibaca.
     */
    public function markAllAsRead()
    {
        Auth::user()->unreadNotifications->markAsRead();
        return back()->with('success', 'Semua notifikasi telah ditandai sebagai sudah dibaca.');
    }
}
