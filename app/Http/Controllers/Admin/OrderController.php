<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Order::with(['user', 'items.product'])->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }

    public function show($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        $total = $order->total;
        return view('admin.orders.show', compact('order', 'total'));
    }

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => ['required', Rule::in(['pending', 'paid', 'processing', 'completed', 'cancelled'])],
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $order->status = $request->status;
        
        // Jika status berubah menjadi completed, update stok
        if ($oldStatus !== 'completed' && $request->status === 'completed') {
            foreach ($order->items as $item) {
                $product = $item->product;
                if ($product && $product->stok < $item->quantity) {
                    return redirect()->back()->with('error', 'Stok produk ' . $product->nama . ' tidak mencukupi.');
                }
            }
        }

        // Jika status diubah menjadi paid, otomatis update payment_status
        if ($request->status === 'paid') {
            $order->payment_status = 'paid';
        }
        
        $order->save();
        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function verifyPayment(Request $request, $id)
    {
        $order = Order::findOrFail($id);
        
        $request->validate([
            'payment_status' => 'required|in:paid,unpaid',
            'payment_notes' => 'nullable|string'
        ]);

        $order->payment_status = $request->payment_status;
        $order->payment_notes = $request->payment_notes;
        $order->save();

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui');
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

        $callback = function() use ($orders) {
            $file = fopen('php://output', 'w');
            
            // Add headers
            fputcsv($file, [
                'ID',
                'Tanggal',
                'Nama Pembeli',
                'Email',
                'Telepon',
                'Alamat',
                'Total Items',
                'Total Harga',
                'Status'
            ]);

            // Add data rows
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
        };

        return Response::stream($callback, 200, $headers);
    }

    public function filter(Request $request)
    {
        $query = Order::with(['user', 'items.product']);

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(10);
        return view('admin.orders.index', compact('orders'));
    }
}
