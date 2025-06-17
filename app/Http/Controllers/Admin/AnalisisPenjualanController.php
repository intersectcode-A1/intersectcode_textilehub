<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;

class AnalisisPenjualanController extends Controller
{
    public function index()
    {
        // Data untuk analisis penjualan
        $totalPenjualan = Order::where('status', 'completed')->sum('total');
        $jumlahTransaksi = Order::where('status', 'completed')->count();
        $rataRataTransaksi = $jumlahTransaksi > 0 ? $totalPenjualan / $jumlahTransaksi : 0;

        // Data untuk grafik penjualan harian (7 hari terakhir)
        $penjualanHarian = Order::where('status', 'completed')
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('SUM(total) as total_penjualan')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $labelsHarian = $penjualanHarian->map(function($item) {
            return Carbon::parse($item->tanggal)->format('d M');
        });
        $dataHarian = $penjualanHarian->pluck('total_penjualan');

        // Data untuk grafik kategori produk
        $kategoriProduk = DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('order_items.order_id', function($query) {
                $query->select('id')
                    ->from('orders')
                    ->where('status', 'completed')
                    ->where('created_at', '>=', Carbon::now()->subDays(7));
            })
            ->select(
                'categories.name as kategori',
                DB::raw('SUM(order_items.quantity * order_items.price) as total_penjualan')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_penjualan', 'desc')
            ->limit(5)
            ->get();

        $labelsKategori = $kategoriProduk->pluck('kategori');
        $dataKategori = $kategoriProduk->pluck('total_penjualan');

        return view('admin.analisis_penjualan.index', [
            'totalPenjualan' => $totalPenjualan,
            'jumlahTransaksi' => $jumlahTransaksi,
            'rataRataTransaksi' => $rataRataTransaksi,
            'labelsHarian' => $labelsHarian,
            'dataHarian' => $dataHarian,
            'labelsKategori' => $labelsKategori,
            'dataKategori' => $dataKategori
        ]);
    }
} 