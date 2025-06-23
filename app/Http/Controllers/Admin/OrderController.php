<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        $orders = $this->getOrdersPaginated();
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        return view('admin.orders.show', [
            'order' => $order,
            'total' => $order->total,
        ]);
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', Rule::in(['pending', 'processing', 'completed', 'cancelled'])],
        ]);

        $order = Order::with('items.product')->findOrFail($id);
        $oldStatus = $order->status;

        if ($oldStatus !== 'completed' && $request->status === 'completed') {
            foreach ($order->items as $item) {
                if ($item->product && $item->product->stok < $item->quantity) {
                    return back()->with('error', "Stok produk {$item->product->nama} tidak mencukupi.");
                }
            }
        }

        $order->status = $request->status;
        $order->save();

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }

    public function export()
    {
        $orders = Order::with(['items', 'user'])->get();
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=orders.csv',
        ];

        return Response::stream(function () use ($orders) {
            $file = fopen('php://output', 'w');
            fputcsv($file, [
                'ID', 'Tanggal', 'Nama Pembeli', 'Email', 'Telepon', 'Alamat',
                'Total Items', 'Total Harga', 'Status'
            ]);

            foreach ($orders as $order) {
                fputcsv($file, [
                    $order->id,
                    $order->created_at->format('d/m/Y H:i'),
                    $order->user_name,
                    $order->email,
                    $order->telepon,
                    $order->alamat,
                    $order->items->count(),
                    $order->total,
                    ucfirst($order->status)
                ]);
            }

            fclose($file);
        }, 200, $headers);
    }

    public function filter(Request $request)
    {
        $query = Order::with(['user', 'items.product']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function verifyPayment(Request $request, $id)
    {
        $request->validate([
            'payment_status' => ['required', Rule::in(['unpaid', 'paid'])],
        ]);

        $order = Order::findOrFail($id);
        $order->payment_status = $request->payment_status;
        $order->save();

        // TODO: Tambahkan pengiriman notifikasi di sini

        return back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    // Helper method
    private function getOrdersPaginated()
    {
        return Order::with(['user', 'items.product'])->latest()->paginate(10);
    }
}
