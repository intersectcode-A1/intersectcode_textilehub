<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class HargaStrategiController extends Controller
{
    public function index()
    {
        // Ambil produk dengan data penjualan
        $products = Product::withCount(['orderItems as total_terjual'])
            ->with('category')
            ->get()
            ->map(function ($product) {
                // Hitung margin keuntungan (asumsi cost adalah 70% dari harga jual)
                $cost = $product->harga * 0.7;
                $margin = $product->harga - $cost;
                $margin_percentage = ($margin / $product->harga) * 100;

                return [
                    'id' => $product->id,
                    'nama' => $product->nama,
                    'kategori' => $product->category->nama ?? 'Tanpa Kategori',
                    'harga_current' => $product->harga,
                    'stok' => $product->stok,
                    'terjual' => $product->total_terjual,
                    'margin' => round($margin),
                    'margin_percentage' => round($margin_percentage, 2)
                ];
            });

        // Analisis tren penjualan 30 hari terakhir
        $salesTrend = Order::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as total_orders'),
            DB::raw('SUM(total) as total_revenue')
        )
            ->where('status', 'completed')
            ->where('created_at', '>=', Carbon::now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Rekomendasi harga berdasarkan kategori
        $categoryAnalysis = Category::withCount('products')
            ->withAvg('products', 'harga')
            ->having('products_count', '>', 0)
            ->get()
            ->map(function ($category) {
                return [
                    'nama' => $category->nama,
                    'jumlah_produk' => $category->products_count,
                    'rata_harga' => round($category->products_avg_harga),
                    'rekomendasi_minimum' => round($category->products_avg_harga * 0.8),
                    'rekomendasi_maximum' => round($category->products_avg_harga * 1.2)
                ];
            });

        return view('admin.harga-strategi.index', compact(
            'products',
            'salesTrend',
            'categoryAnalysis'
        ));
    }

    public function updateHarga(Request $request, Product $product)
    {
        $request->validate([
            'harga_baru' => 'required|numeric|min:0'
        ]);

        // Simpan harga lama
        $old_price = $product->harga;

        // Update harga produk
        $product->harga = $request->harga_baru;
        $product->save();

        // Catat riwayat perubahan harga
        $product->priceHistory()->create([
            'old_price' => $old_price,
            'new_price' => $request->harga_baru,
            'user_id' => auth()->id()
        ]);

        return redirect()->back()->with('success', 'Harga produk berhasil diperbarui');
    }

    public function analisisProduk($id)
    {
        // Ambil produk dengan relasi yang diperlukan
        $product = Product::with(['category', 'priceHistory.user'])->findOrFail($id);

        // Hitung margin
        $cost = $product->harga * 0.7; // asumsi cost 70% dari harga jual
        $margin = $product->harga - $cost;
        $margin_percentage = ($margin / $product->harga) * 100;

        // Tambahkan properti yang diperlukan
        $product->margin_percentage = round($margin_percentage, 2);
        $product->harga_current = $product->harga;

        // Analisis penjualan 6 bulan terakhir
        $sales_data = DB::table('order_items')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('order_items.product_id', $id)
            ->where('orders.status', 'completed')
            ->where('orders.created_at', '>=', Carbon::now()->subMonths(6))
            ->select(
                DB::raw('DATE_FORMAT(orders.created_at, "%b %Y") as month'),
                DB::raw('YEAR(orders.created_at) as year'),
                DB::raw('MONTH(orders.created_at) as month_num'),
                DB::raw('SUM(order_items.quantity) as total')
            )
            ->groupBy(
                DB::raw('DATE_FORMAT(orders.created_at, "%b %Y")'),
                DB::raw('YEAR(orders.created_at)'),
                DB::raw('MONTH(orders.created_at)')
            )
            ->orderBy('year')
            ->orderBy('month_num')
            ->get();

        // Riwayat perubahan harga
        $price_history = $product->priceHistory()
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%d %b %Y") as date'),
                'new_price as price'
            )
            ->orderBy('created_at')
            ->get();

        // Hitung statistik
        $stats = [
            'total_terjual' => $sales_data->sum('total'),
            'avg_harga' => $price_history->avg('price') ?? $product->harga,
            'min_harga' => $price_history->min('price') ?? $product->harga,
            'max_harga' => $price_history->max('price') ?? $product->harga
        ];

        // Tambahkan statistik ke produk
        $product->total_terjual = $stats['total_terjual'];
        $product->avg_harga = $stats['avg_harga'];
        $product->min_harga = $stats['min_harga'];
        $product->max_harga = $stats['max_harga'];

        // Hitung rekomendasi harga
        $avg_category_price = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->avg('harga') ?? $product->harga;

        $product->recommended_price = round($avg_category_price * 1.1); // 10% di atas rata-rata kategori
        $product->min_recommended_price = round($cost * 1.2); // minimal 20% margin
        $product->competitive_price = round($avg_category_price); // harga kompetitif sesuai kategori
        $product->recommended_margin = round((($product->recommended_price - $cost) / $product->recommended_price) * 100, 2);

        return view('admin.harga-strategi.analisis', compact(
            'product',
            'sales_data',
            'price_history'
        ));
    }
}
