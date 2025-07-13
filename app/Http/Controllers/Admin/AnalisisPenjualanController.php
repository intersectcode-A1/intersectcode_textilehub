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
use App\Models\InventoryLog;
use App\Exports\SalesAnalysisExport;
use Maatwebsite\Excel\Facades\Excel;

class AnalisisPenjualanController extends Controller
{
    public function index(Request $request)
    {
        // 1. Tentukan Periode
        $period = $request->input('period', 7); // Default 7 hari
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subDays($period);
        
        $prevEndDate = $startDate->copy()->subDay();
        $prevStartDate = $prevEndDate->copy()->subDays($period);

        // 2. Data Periode Saat Ini
        $currentData = $this->getSalesData($startDate, $endDate);
        
        // 3. Data Periode Sebelumnya
        $previousData = $this->getSalesData($prevStartDate, $prevEndDate);

        // 4. Hitung Pertumbuhan
        $persentasePertumbuhan = $this->calculateGrowth($currentData['totalPenjualan'], $previousData['totalPenjualan']);
        $persentaseTransaksi = $this->calculateGrowth($currentData['jumlahTransaksi'], $previousData['jumlahTransaksi']);
        $persentaseRataRata = $this->calculateGrowth($currentData['rataRataTransaksi'], $previousData['rataRataTransaksi']);

        // 5. Data Grafik
        $penjualanHarian = $this->getDailySales($startDate, $endDate);
        $labelsHarian = $penjualanHarian->map(fn($item) => Carbon::parse($item->tanggal)->format('d M'));
        $dataHarian = $penjualanHarian->pluck('total_penjualan');
        
        // Cek apakah ada data untuk query kategori dan produk terlaris
        $kategoriProduk = collect();
        $produkTerlarisList = collect();
        
        try {
            $kategoriProduk = $this->getCategorySales($startDate, $endDate);
            $produkTerlarisList = $this->getTopSellingProducts($startDate, $endDate, 10);
        } catch (\Exception $e) {
            // Jika ada error, gunakan data kosong
            Log::error('Error in sales analysis: ' . $e->getMessage());
        }
        
        $labelsKategori = $kategoriProduk->pluck('kategori');
        $dataKategori = $kategoriProduk->pluck('total_penjualan');
        
        // 6. Data Produk Terlaris
        $produkTerlarisTop = $produkTerlarisList->first();

        // 7. Data Inventory Logs
        $inventorySummary = InventoryLog::getSummary($startDate, $endDate);
        $recentInventoryLogs = $this->getRecentInventoryLogs($startDate, $endDate);
        $inventoryChartData = $this->getInventoryChartData($startDate, $endDate);

        return view('admin.analisis_penjualan.index', [
            'totalPenjualan' => $currentData['totalPenjualan'],
            'jumlahTransaksi' => $currentData['jumlahTransaksi'],
            'rataRataTransaksi' => $currentData['rataRataTransaksi'],
            'persentasePertumbuhan' => $persentasePertumbuhan,
            'persentaseTransaksi' => $persentaseTransaksi,
            'persentaseRataRata' => $persentaseRataRata,
            'labelsHarian' => $labelsHarian,
            'dataHarian' => $dataHarian,
            'labelsKategori' => $labelsKategori,
            'dataKategori' => $dataKategori,
            'produkTerlarisList' => $produkTerlarisList,
            'produkTerlaris' => $produkTerlarisTop->nama ?? '-',
            'jumlahTerjual' => $produkTerlarisTop->jumlah_terjual ?? 0,
            'inventorySummary' => $inventorySummary,
            'recentInventoryLogs' => $recentInventoryLogs,
            'inventoryChartData' => $inventoryChartData,
        ]);
    }

    private function getSalesData($startDate, $endDate)
    {
        $query = Order::where('status', 'completed')->whereBetween('created_at', [$startDate, $endDate]);
        
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
            ->groupBy('tanggal')->orderBy('tanggal')->get();
    }

    private function getCategorySales($startDate, $endDate)
    {
        try {
            // Cek apakah tabel yang diperlukan ada
            if (!Schema::hasTable('orders') || !Schema::hasTable('order_items') || !Schema::hasTable('products') || !Schema::hasTable('categories')) {
                return collect();
            }
            
            // Cek apakah ada orders dengan status completed
            $completedOrders = DB::table('orders')
                ->where('status', 'completed')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();
                
            if ($completedOrders == 0) {
                return collect();
            }
            
            // Gunakan subquery untuk menghindari masalah join yang kompleks
            $orderIds = DB::table('orders')
                ->where('status', 'completed')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->pluck('id');
                
            if ($orderIds->isEmpty()) {
                return collect();
            }
            
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
                ->orderBy('total_penjualan', 'desc')
                ->limit(5)->get();
        } catch (\Exception $e) {
            Log::error('Error in getCategorySales: ' . $e->getMessage());
            return collect();
        }
    }

    private function getTopSellingProducts($startDate, $endDate, $limit = 10)
    {
        try {
            // Cek apakah tabel yang diperlukan ada
            if (!Schema::hasTable('orders') || !Schema::hasTable('order_items') || !Schema::hasTable('products') || !Schema::hasTable('categories')) {
                return collect();
            }
            
            // Cek apakah ada orders dengan status completed
            $completedOrders = DB::table('orders')
                ->where('status', 'completed')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->count();
                
            if ($completedOrders == 0) {
                return collect();
            }
            
            // Gunakan subquery untuk menghindari masalah join yang kompleks
            $orderIds = DB::table('orders')
                ->where('status', 'completed')
                ->whereBetween('created_at', [$startDate, $endDate])
                ->pluck('id');
                
            if ($orderIds->isEmpty()) {
                return collect();
            }
            
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
                ->orderBy('jumlah_terjual', 'desc')
                ->limit($limit)->get();
        } catch (\Exception $e) {
            Log::error('Error in getTopSellingProducts: ' . $e->getMessage());
            return collect();
        }
    }

    private function getRecentInventoryLogs($startDate, $endDate)
    {
        try {
            return InventoryLog::with(['product', 'user'])
                ->whereBetween('created_at', [$startDate, $endDate])
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
        } catch (\Exception $e) {
            Log::error('Error in getRecentInventoryLogs: ' . $e->getMessage());
            return collect();
        }
    }

    private function getInventoryChartData($startDate, $endDate)
    {
        try {
            $dailyData = InventoryLog::whereBetween('created_at', [$startDate, $endDate])
                ->select(
                    DB::raw('DATE(created_at) as tanggal'),
                    DB::raw('SUM(CASE WHEN type = "in" THEN quantity ELSE 0 END) as barang_masuk'),
                    DB::raw('SUM(CASE WHEN type = "out" THEN quantity ELSE 0 END) as barang_keluar')
                )
                ->groupBy('tanggal')
                ->orderBy('tanggal')
                ->get();

            return [
                'labels' => $dailyData->map(fn($item) => Carbon::parse($item->tanggal)->format('d M')),
                'barang_masuk' => $dailyData->pluck('barang_masuk'),
                'barang_keluar' => $dailyData->pluck('barang_keluar')
            ];
        } catch (\Exception $e) {
            Log::error('Error in getInventoryChartData: ' . $e->getMessage());
            return [
                'labels' => collect(),
                'barang_masuk' => collect(),
                'barang_keluar' => collect()
            ];
        }
    }

    public function export(Request $request)
    {
        $period = $request->input('period', 7);
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subDays($period);
        
        $prevEndDate = $startDate->copy()->subDay();
        $prevStartDate = $prevEndDate->copy()->subDays($period);

        // Get current period data
        $currentData = $this->getSalesData($startDate, $endDate);
        
        // Get previous period data
        $previousData = $this->getSalesData($prevStartDate, $prevEndDate);

        // Calculate growth percentages
        $persentasePertumbuhan = $this->calculateGrowth($currentData['totalPenjualan'], $previousData['totalPenjualan']);
        $persentaseTransaksi = $this->calculateGrowth($currentData['jumlahTransaksi'], $previousData['jumlahTransaksi']);
        $persentaseRataRata = $this->calculateGrowth($currentData['rataRataTransaksi'], $previousData['rataRataTransaksi']);

        // Prepare data for export
        $exportData = [
            'totalPenjualan' => $currentData['totalPenjualan'],
            'jumlahTransaksi' => $currentData['jumlahTransaksi'],
            'rataRataTransaksi' => $currentData['rataRataTransaksi'],
            'persentasePertumbuhan' => $persentasePertumbuhan,
            'persentaseTransaksi' => $persentaseTransaksi,
            'persentaseRataRata' => $persentaseRataRata,
        ];

        $periodText = match($period) {
            7 => '7_hari',
            30 => '30_hari',
            90 => '3_bulan',
            365 => '1_tahun',
            default => $period . '_hari'
        };

        $filename = 'analisis_penjualan_' . $periodText . '_' . Carbon::now()->format('Y-m-d_H-i-s') . '.xlsx';

        try {
            return Excel::download(new SalesAnalysisExport($period, $exportData), $filename);
        } catch (\Exception $e) {
            Log::error('Error exporting sales analysis: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Terjadi kesalahan saat mengexport data. Silakan coba lagi.');
        }
    }
} 