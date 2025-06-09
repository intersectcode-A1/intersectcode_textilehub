<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

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

    /**
     * Menampilkan riwayat pembelian user
     */
    public function purchaseHistory()
    {
        $orders = Order::where('user_id', Auth::id())
                      ->whereIn('status', ['completed', 'cancelled'])
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);

        return view('ecatalog.purchase-history', compact('orders'));
    }

    /**
     * Menampilkan status pesanan yang sedang aktif
     */
    public function orderStatus()
    {
        $orders = Order::where('user_id', Auth::id())
                      ->orderBy('created_at', 'desc')
                      ->paginate(10);
        return view('ecatalog.order-status', compact('orders'));
    }

    /**
     * Menampilkan detail pesanan
     */
    public function orderDetail($id)
    {
        $order = Order::with('items.product')->findOrFail($id);
        if ($order->user_id !== Auth::id()) {
            return back()->with('error', 'Anda tidak memiliki akses ke pesanan ini');
        }
        return view('ecatalog.order-detail', compact('order'));
    }

    /**
     * Membatalkan pesanan
     */
    public function cancel($id)
    {
        try {
            $order = Order::findOrFail($id);
            
            // Validasi apakah order milik user yang login
            if ($order->user_id !== Auth::id()) {
                return back()->with('error', 'Anda tidak memiliki akses untuk membatalkan pesanan ini');
            }

            // Validasi apakah order masih bisa dibatalkan
            if ($order->status !== 'pending') {
                return back()->with('error', 'Pesanan tidak dapat dibatalkan karena status sudah berubah');
            }

            // Update status pesanan menjadi dibatalkan
            $order->status = 'cancelled';
            $order->save();

            return back()->with('success', 'Pesanan berhasil dibatalkan');

        } catch (\Exception $e) {
            Log::error('Error saat membatalkan pesanan: ' . $e->getMessage());
            return back()->with('error', 'Terjadi kesalahan saat membatalkan pesanan');
        }
    }
}
