<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan (untuk admin).
     */
    public function index()
    {
        $orders = Order::with('user')->latest()->paginate(10); // Include user info if needed
        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail satu pesanan berdasarkan ID.
     */
    public function show($id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id); // Menampilkan detail produk & user jika ada
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Memperbarui status dari pesanan tertentu.
     */
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,proses,selesai',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }
}
