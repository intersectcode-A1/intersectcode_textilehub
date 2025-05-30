<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; // Pastikan model Order sudah dibuat dan namespace benar

class OrderController extends Controller
{
    public function index()
    {
<<<<<<< Updated upstream
        $orders = Order::latest()->paginate(10);
=======
        $orders = Order::with('user')->latest()->paginate(10);
>>>>>>> Stashed changes
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
<<<<<<< Updated upstream
        $order = Order::with('items')->findOrFail($id);
        return view('admin.orders.show', compact('order'));
=======
        $order = Order::with(['items.product', 'user'])->findOrFail($id);

        // Hitung total pesanan
        $total = $order->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        return view('admin.orders.show', compact('order', 'total'));
>>>>>>> Stashed changes
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:pending,proses,selesai',
        ]);

        $order = Order::findOrFail($id);
        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Status pesanan diperbarui.');
    }
}
