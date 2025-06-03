<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index()
    {
        // Ambil produk terbaru, 9 per halaman
        $products = Product::latest()->paginate(9);

        // Kirim ke view
        return view('user.catalog.index', compact('products'));
    }

    public function show($id)
    {
        // Cari produk berdasar id, jika tidak ada tampil error 404
        $product = Product::findOrFail($id);

        return view('user.catalog.show', compact('product'));
    }

    public function purchaseHistory(Request $request)
    {
        $query = Order::where('user_id', auth()->id())
            ->where('status', 'completed')
            ->latest();

        // Filter berdasarkan tanggal
        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $orders = $query->paginate(10);

        return view('ecatalog.purchase-history', compact('orders'));
    }

    public function orderStatus(Request $request)
    {
        $query = Order::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'processing'])
            ->latest();

        // Filter berdasarkan status
        if ($request->status) {
            $query->where('status', $request->status);
        }

        // Filter berdasarkan tanggal
        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $orders = $query->paginate(10);

        return view('ecatalog.order-status', compact('orders'));
    }

    public function orderDetail($id)
    {
        $order = Order::where('user_id', auth()->id())
            ->with('items.product')
            ->findOrFail($id);

        return view('ecatalog.order-detail', compact('order'));
    }

    public function cancel($id)
    {
        $order = Order::where('user_id', auth()->id())->findOrFail($id);

        if (!$order->canBeCancelled()) {
            return back()->with('error', 'Pesanan ini tidak dapat dibatalkan.');
        }

        $order->status = Order::STATUS_CANCELLED;
        $order->save();

        // Kembalikan stok produk
        foreach ($order->items as $item) {
            $product = $item->product;
            if ($product) {
                $product->stok += $item->quantity;
                $product->save();
            }
        }

        return back()->with('success', 'Pesanan berhasil dibatalkan.');
    }
}
