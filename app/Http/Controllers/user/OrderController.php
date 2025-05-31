<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar pesanan berdasarkan email user.
     */
    public function index(Request $request)
    {
        $email = $request->get('email');

        if (!$email) {
            return view('ecatalog.status', [
                'orders' => collect(),
                'message' => 'Masukkan email untuk melihat pesanan'
            ]);
        }

        $orders = Order::where('email', $email)->latest()->get();

        return view('ecatalog.status', compact('orders', 'email'));
    }

    /**
     * Membatalkan pesanan jika status masih pending/null.
     */
    public function cancel($id)
    {
        $order = Order::findOrFail($id);

        // Cek apakah status pesanan masih bisa dibatalkan
        if ($order->status === 'pending' || $order->status === null) {
            $order->status = 'dibatalkan';
            $order->save();

            return redirect()->route('order.status')->with('success', 'Pesanan berhasil dibatalkan.');
        }

        return redirect()->route('order.status')->with('error', 'Pesanan tidak dapat dibatalkan karena sudah diproses atau selesai.');
    }
}
