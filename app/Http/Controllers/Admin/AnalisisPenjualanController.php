<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;

class AnalisisPenjualanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Tentukan Periode
        $period = $request->input('period', 7);
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subDays($period);
        $prevEndDate = $startDate->copy()->subDay();
        $prevStartDate = $prevEndDate->copy()->subDays($period);

        // 2. Ambil data penjualan
        $currentData = $this->getSalesData($startDate, $endDate);
        $previousData = $this->getSalesData($prevStartDate, $prevEndDate);

        // 3. Hitung pertumbuhan
        $growth = [
            'penjualan' => $this->calculateGrowth($currentData['totalPenjualan'], $previousData['totalPenjualan']),
            'transaksi' => $this->calculateGrowth($currentData['jumlahTransaksi'], $previousData['jumlahTransaksi']),
            'rataRata' => $this->calculateGrowth($currentData['rataRataTransaksi'], $previousData['rataRataTransaksi']),
        ];

        // 4. Grafik harian
        $dailySales = $this->getDailySales($startDate, $endDate);
        $labelsHarian = $dailySales->pluck('tanggal')->map(fn($tgl) => Carbon::parse($tgl)->format('d M'));
        $dataHarian = $dailySales->pluck('total_penjualan');

        // 5. Kategori dan Produk Terlaris
        $kategoriProduk = collect();
        $produkTerlarisList = collect();

        try {
            if ($this->tablesExist(['orders', 'order_items', 'products', 'categories'])) {
                $kategoriProduk = $this->getCategorySales($startDate, $endDate);
                $produkTerlarisList = $this->getTopSellingProducts($startDate, $endDate, 10);
            }
        } catch (\Exception $e) {
            Log::error('Error in sales analysis: ' . $e->getMessage());
        }

        $labelsKategori = $kategoriProduk->pluck('kategori');
        $dataKategori = $kategoriProduk->pluck('total_penjualan');

        $produkTerlarisTop = $produkTerlarisList->first();

        return view('admin.analisis_penjualan.index', [
            'totalPenjualan' => $currentData['totalPenjualan'],
            'jumlahTransaksi' => $currentData['jumlahTransaksi'],
            'rataRataTransaksi' => $currentData['rataRataTransaksi'],
            'persentasePertumbuhan' => $growth['penjualan'],
            'persentaseTransaksi' => $growth['transaksi'],
            'persentaseRataRata' => $growth['rataRata'],
            'labelsHarian' => $labelsHarian,
            'dataHarian' => $dataHarian,
            'labelsKategori' => $labelsKategori,
            'dataKategori' => $dataKategori,
            'produkTerlarisList' => $produkTerlarisList,
            'produkTerlaris' => $produkTerlarisTop->nama ?? '-',
            'jumlahTerjual' => $produkTerlarisTop->jumlah_terjual ?? 0,
        ]);
    }

    private function getSalesData($startDate, $endDate)
    {
        $query = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate]);

        $totalPenjualan = $query->sum('total');
        $jumlahTransaksi = $query->count();
        $rataRataTransaksi = $jumlahTransaksi > 0 ? $totalPenjualan / $jumlahTransaksi : 0;

        return compact('totalPenjualan', 'jumlahTransaksi', 'rataRataTransaksi');
    }

    private function calculateGrowth($current, $previous)
    {
        if ($previous == 0) {
            return $current > 0 ? 100 : 0;
        }

        return (($current - $previous) / $previous) * 100;
    }

    private function getDailySales($startDate, $endDate)
    {
        return Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('SUM(total) as total_penjualan')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();
    }

    private function getCategorySales($startDate, $endDate)
    {
        $orderIds = $this->getCompletedOrderIds($startDate, $endDate);
        if ($orderIds->isEmpty()) return collect();

        return DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->whereIn('order_items.order_id', $orderIds)
            ->whereNotNull('products.category_id')
            ->select(
                'categories.name as kategori',
                DB::raw('SUM(order_items.quantity * order_items.price) as total_penjualan')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderByDesc('total_penjualan')
            ->limit(5)
            ->get();
    }

    private function getTopSellingProducts($startDate, $endDate, $limit = 10)
    {
        $orderIds = $this->getCompletedOrderIds($startDate, $endDate);
        if ($orderIds->isEmpty()) return collect();

        return DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->whereIn('order_items.order_id', $orderIds)
            ->whereNotNull('products.category_id')
            ->select(
                'products.nama as nama',
                'categories.name as kategori',
                DB::raw('SUM(order_items.quantity) as jumlah_terjual'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_penjualan')
            )
            ->groupBy('products.id', 'products.nama', 'categories.name')
            ->orderByDesc('jumlah_terjual')
            ->limit($limit)
            ->get();
    }

    private function getCompletedOrderIds($startDate, $endDate)
    {
        return DB::table('orders')
            ->where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->pluck('id');
    }

    private function tablesExist(array $tables): bool
    {
        foreach ($tables as $table) {
            if (!Schema::hasTable($table)) return false;
        }
        return true;
    }
}
