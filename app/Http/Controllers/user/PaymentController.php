<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

class PaymentController extends Controller
{
    /**
     * Menampilkan form pembayaran
     */
    public function show($id)
    {
        $order = Order::where('user_id', auth()->id())
            ->findOrFail($id);

        if ($order->status !== 'completed') {
            return redirect()->route('purchase.history')
                ->with('error', 'Pesanan belum siap untuk dibayar.');
        }

        if ($order->payment_status === 'paid') {
            return redirect()->route('purchase.history')
                ->with('error', 'Pesanan ini sudah dibayar.');
        }

        return view('ecatalog.payment', compact('order'));
    }

    /**
     * Memproses pembayaran
     */
    public function process(Request $request, $id)
    {
        $order = Order::where('user_id', auth()->id())
            ->findOrFail($id);

        if ($order->status !== 'completed') {
            return redirect()->route('purchase.history')
                ->with('error', 'Pesanan belum siap untuk dibayar.');
        }

        if ($order->payment_status === 'paid') {
            return redirect()->route('purchase.history')
                ->with('error', 'Pesanan ini sudah dibayar.');
        }

        $request->validate([
            'payment_proof' => 'required|image|max:2048', // maksimal 2MB
        ]);

        try {
            // Upload bukti pembayaran
            $path = $request->file('payment_proof')->store('payment-proofs', 'public');

            // Update status pembayaran
            $order->payment_proof = $path;
            $order->payment_status = 'paid';
            $order->save();

            return redirect()->route('purchase.history')
                ->with('success', 'Pembayaran berhasil diproses. Tim kami akan segera memverifikasi pembayaran Anda.');

        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat memproses pembayaran. Silakan coba lagi.');
        }
    }
} 