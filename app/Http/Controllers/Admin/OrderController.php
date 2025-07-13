<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\InventoryLog;
use Illuminate\Support\Facades\Response;
use Illuminate\Validation\Rule;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with(['user', 'items.product']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $orders = $query->latest()->paginate(10)->withQueryString();
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
            'status' => ['required', Rule::in(['pending', 'processing', 'completed', 'cancelled'])],
        ]);

        $order = Order::findOrFail($id);
        $oldStatus = $order->status;
        $order->status = $request->status;

        // Jika status berubah menjadi completed, update stok dan log inventory
        if ($oldStatus !== 'completed' && $request->status === 'completed') {
            foreach ($order->items as $item) {
                $product = $item->product;
                if ($product && $product->stok < $item->quantity) {
                    return redirect()->back()->with('error', 'Stok produk ' . $product->nama . ' tidak mencukupi.');
                }
            }
            
            // Log barang keluar untuk setiap item
            foreach ($order->items as $item) {
                if ($item->product) {
                    InventoryLog::logOutgoing(
                        $item->product->id,
                        $item->quantity,
                        'Penjualan - Order #' . $order->order_number,
                        'order',
                        $order->id,
                        null
                    );
                }
            }
        }

        $order->save();
        return redirect()->back()->with('success', 'Status pesanan berhasil diperbarui.');
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

    public function verifyPayment(Request $request, $id)
    {
        $request->validate([
            'payment_status' => ['required', Rule::in(['unpaid', 'paid'])],
        ]);

        $order = Order::findOrFail($id);
        $order->payment_status = $request->payment_status;
        $order->save();

        // Jika pembayaran diverifikasi, kirim notifikasi ke user
        if ($request->payment_status === 'paid') {
            // TODO: Implementasi notifikasi ke user bisa ditambahkan di sini
        }

        return redirect()->back()->with('success', 'Status pembayaran berhasil diperbarui.');
    }

    public function invoice($id)
    {
        $order = Order::with(['items.product', 'user'])->findOrFail($id);
        $total = $order->total;
        $pdf = PDF::loadView('ecatalog.invoice-pdf', compact('order', 'total'));
        return $pdf->download('invoice-order-' . $order->id . '.pdf');
    }
}
