<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanKeuanganExport;

class LaporanKeuanganController extends Controller
{
    public function index()
    {
        // Default periode 30 hari jika tidak ada request
        $endDate = Carbon::now();
        $startDate = Carbon::now()->subDays(30);

        return $this->getLaporanData($startDate, $endDate);
    }

    public function filter(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
        ], [
            'tanggal_mulai.required' => 'Tanggal mulai harus diisi',
            'tanggal_mulai.date' => 'Format tanggal mulai tidak valid',
            'tanggal_akhir.required' => 'Tanggal akhir harus diisi',
            'tanggal_akhir.date' => 'Format tanggal akhir tidak valid',
            'tanggal_akhir.after_or_equal' => 'Tanggal akhir harus sama dengan atau setelah tanggal mulai'
        ]);

        $startDate = Carbon::parse($request->tanggal_mulai);
        $endDate = Carbon::parse($request->tanggal_akhir);

        return $this->getLaporanData($startDate, $endDate);
    }

    public function export(Request $request)
    {
        $request->validate([
            'tanggal_mulai' => 'required|date',
            'tanggal_akhir' => 'required|date|after_or_equal:tanggal_mulai',
        ]);

        $startDate = Carbon::parse($request->tanggal_mulai);
        $endDate = Carbon::parse($request->tanggal_akhir);

        $filename = 'laporan-keuangan-' . $startDate->format('Y-m-d') . '-sampai-' . $endDate->format('Y-m-d') . '.xlsx';

        return Excel::download(new LaporanKeuanganExport($startDate, $endDate), $filename);
    }

    private function getLaporanData($startDate, $endDate)
    {
        try {
            // 1. DATA PENJUALAN (PENDAPATAN)
            $penjualanData = $this->getPenjualanData($startDate, $endDate);
            
            // 2. DATA PENGELUARAN (dari transaksis jika ada, atau estimasi)
            $pengeluaranData = $this->getPengeluaranData($startDate, $endDate);
            
            // 3. ANALISIS PROFITABILITAS
            $profitabilitasData = $this->getProfitabilitasData($startDate, $endDate);
            
            // 4. CASH FLOW
            $cashFlowData = $this->getCashFlowData($startDate, $endDate);
            
            // 5. PERBANDINGAN DENGAN PERIODE SEBELUMNYA
            $periodeSebelumnya = [
                'start' => $startDate->copy()->subDays($endDate->diffInDays($startDate)),
                'end' => $startDate->copy()->subDay()
            ];
            
            $dataSebelumnya = $this->getPenjualanData($periodeSebelumnya['start'], $periodeSebelumnya['end']);
            
            // Hitung persentase perubahan
            $persentasePendapatan = $this->hitungPersentasePerubahan($penjualanData['totalPendapatan'], $dataSebelumnya['totalPendapatan']);
            $persentasePengeluaran = $this->hitungPersentasePerubahan($pengeluaranData['totalPengeluaran'], $dataSebelumnya['totalPengeluaran'] ?? 0);
            $persentaseProfit = $this->hitungPersentasePerubahan($profitabilitasData['totalProfit'], $dataSebelumnya['totalProfit'] ?? 0);

            return view('admin.laporan_keuangan.index', [
                'startDate' => $startDate->format('Y-m-d'),
                'endDate' => $endDate->format('Y-m-d'),
                
                // Data Penjualan
                'totalPendapatan' => $penjualanData['totalPendapatan'],
                'jumlahTransaksi' => $penjualanData['jumlahTransaksi'],
                'rataRataTransaksi' => $penjualanData['rataRataTransaksi'],
                'penjualanHarian' => $penjualanData['penjualanHarian'],
                
                // Data Pengeluaran
                'totalPengeluaran' => $pengeluaranData['totalPengeluaran'],
                'kategoriPengeluaran' => $pengeluaranData['kategoriPengeluaran'],
                'expenses' => $pengeluaranData['expenses'],
                
                // Data Profitabilitas
                'totalProfit' => $profitabilitasData['totalProfit'],
                'marginProfit' => $profitabilitasData['marginProfit'],
                'produkTerlaris' => $profitabilitasData['produkTerlaris'],
                'kategoriTerlaris' => $profitabilitasData['kategoriTerlaris'],
                
                // Data Cash Flow
                'cashFlow' => $cashFlowData,
                
                // Persentase Perubahan
                'persentasePendapatan' => $persentasePendapatan,
                'persentasePengeluaran' => $persentasePengeluaran,
                'persentaseProfit' => $persentaseProfit,
                
                // Data untuk Grafik
                'labelsGrafik' => $penjualanData['labelsGrafik'],
                'dataPendapatan' => $penjualanData['dataPendapatan'],
                'dataPengeluaran' => $pengeluaranData['dataPengeluaran'],
                'dataProfit' => $profitabilitasData['dataProfit'],
            ]);
        } catch (\Exception $e) {
            return back()->withErrors('Terjadi kesalahan sistem: ' . $e->getMessage());
        }
    }

    private function getPenjualanData($startDate, $endDate)
    {
        // Data penjualan dari orders yang completed
        $orders = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();

        $totalPendapatan = $orders->sum('total');
        $jumlahTransaksi = $orders->count();
        $rataRataTransaksi = $jumlahTransaksi > 0 ? $totalPendapatan / $jumlahTransaksi : 0;

        // Data harian untuk grafik
        $penjualanHarian = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('SUM(total) as total_penjualan'),
                DB::raw('COUNT(*) as jumlah_transaksi')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $labelsGrafik = $penjualanHarian->map(function($item) {
            return Carbon::parse($item->tanggal)->format('d M');
        });
        $dataPendapatan = $penjualanHarian->pluck('total_penjualan');

        return [
            'totalPendapatan' => $totalPendapatan,
            'jumlahTransaksi' => $jumlahTransaksi,
            'rataRataTransaksi' => $rataRataTransaksi,
            'penjualanHarian' => $penjualanHarian,
            'labelsGrafik' => $labelsGrafik,
            'dataPendapatan' => $dataPendapatan,
        ];
    }

    private function getPengeluaranData($startDate, $endDate)
    {
        // Ambil data pengeluaran dari database
        $expenses = DB::table('expenses')
            ->join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
            ->whereBetween('expenses.tanggal', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->select(
                'expense_categories.nama as kategori',
                DB::raw('SUM(expenses.nominal) as total'),
                DB::raw('COUNT(*) as jumlah_transaksi')
            )
            ->groupBy('expense_categories.id', 'expense_categories.nama')
            ->orderBy('total', 'desc')
            ->get();

        $kategoriPengeluaran = [];
        $totalPengeluaran = 0;

        foreach ($expenses as $expense) {
            $kategoriPengeluaran[$expense->kategori] = $expense->total;
            $totalPengeluaran += $expense->total;
        }

        // Data harian untuk grafik
        $pengeluaranHarian = DB::table('expenses')
            ->whereBetween('tanggal', [$startDate->format('Y-m-d'), $endDate->format('Y-m-d')])
            ->select(
                DB::raw('DATE(tanggal) as tanggal'),
                DB::raw('SUM(nominal) as total_pengeluaran')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        $dataPengeluaran = $pengeluaranHarian->pluck('total_pengeluaran');

        return [
            'totalPengeluaran' => $totalPengeluaran,
            'kategoriPengeluaran' => $kategoriPengeluaran,
            'dataPengeluaran' => $dataPengeluaran,
            'expenses' => $expenses,
        ];
    }

    private function getProfitabilitasData($startDate, $endDate)
    {
        // Hitung profit berdasarkan harga modal dari supplier
        $orderItems = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->leftJoin('suppliers', 'products.supplier_id', '=', 'suppliers.id')
            ->where('orders.status', 'completed')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select(
                'order_items.*',
                'products.harga as harga_jual',
                'suppliers.harga_modal as harga_modal'
            )
            ->get();

        $totalRevenue = $orderItems->sum(function($item) {
            return $item->price * $item->quantity;
        });

        $totalCost = $orderItems->sum(function($item) {
            $hargaModal = $item->harga_modal ?? ($item->harga_jual * 0.7); // Estimasi 70% dari harga jual
            return $hargaModal * $item->quantity;
        });

        $totalProfit = $totalRevenue - $totalCost;
        $marginProfit = $totalRevenue > 0 ? ($totalProfit / $totalRevenue) * 100 : 0;

        // Produk terlaris berdasarkan profit
        $produkTerlaris = $this->getProdukTerlarisByProfit($startDate, $endDate);
        
        // Kategori terlaris berdasarkan profit
        $kategoriTerlaris = $this->getKategoriTerlarisByProfit($startDate, $endDate);

        // Data profit harian untuk grafik
        $profitHarian = $this->getProfitHarian($startDate, $endDate);
        $dataProfit = $profitHarian->pluck('total_profit');

        return [
            'totalProfit' => $totalProfit,
            'marginProfit' => $marginProfit,
            'totalRevenue' => $totalRevenue,
            'totalCost' => $totalCost,
            'produkTerlaris' => $produkTerlaris,
            'kategoriTerlaris' => $kategoriTerlaris,
            'dataProfit' => $dataProfit,
        ];
    }

    private function getCashFlowData($startDate, $endDate)
    {
        $penjualanData = $this->getPenjualanData($startDate, $endDate);
        $pengeluaranData = $this->getPengeluaranData($startDate, $endDate);
        $profitabilitasData = $this->getProfitabilitasData($startDate, $endDate);

        return [
            'operating_activities' => [
                'pendapatan_penjualan' => $penjualanData['totalPendapatan'],
                'pengeluaran_operasional' => -$pengeluaranData['totalPengeluaran'],
                'net_cash_operating' => $penjualanData['totalPendapatan'] - $pengeluaranData['totalPengeluaran']
            ],
            'investing_activities' => [
                'pembelian_aset' => -$this->estimasiPembelianAset($startDate, $endDate),
                'net_cash_investing' => -$this->estimasiPembelianAset($startDate, $endDate)
            ],
            'financing_activities' => [
                'pinjaman' => $this->estimasiPinjaman($startDate, $endDate),
                'pembayaran_pinjaman' => -$this->estimasiPembayaranPinjaman($startDate, $endDate),
                'net_cash_financing' => $this->estimasiPinjaman($startDate, $endDate) - $this->estimasiPembayaranPinjaman($startDate, $endDate)
            ]
        ];
    }

    // Helper methods untuk estimasi
    private function estimasiPembelianStok($startDate, $endDate)
    {
        // Estimasi 60% dari total penjualan
        $totalPenjualan = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total');
        return $totalPenjualan * 0.6;
    }

    private function estimasiOperasional($startDate, $endDate)
    {
        // Estimasi 15% dari total penjualan
        $totalPenjualan = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total');
        return $totalPenjualan * 0.15;
    }

    private function estimasiGajiKaryawan($startDate, $endDate)
    {
        // Estimasi tetap per bulan
        $jumlahHari = $startDate->diffInDays($endDate);
        return 5000000 * ($jumlahHari / 30); // 5 juta per bulan
    }

    private function estimasiMarketing($startDate, $endDate)
    {
        // Estimasi 10% dari total penjualan
        $totalPenjualan = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('total');
        return $totalPenjualan * 0.10;
    }

    private function estimasiPengeluaranHarian($startDate, $endDate)
    {
        $totalPengeluaran = $this->estimasiPembelianStok($startDate, $endDate) +
                           $this->estimasiOperasional($startDate, $endDate) +
                           $this->estimasiGajiKaryawan($startDate, $endDate) +
                           $this->estimasiMarketing($startDate, $endDate);

        $jumlahHari = $startDate->diffInDays($endDate) + 1;
        $pengeluaranPerHari = $totalPengeluaran / $jumlahHari;

        $pengeluaranHarian = collect();
        for ($i = 0; $i < $jumlahHari; $i++) {
            $tanggal = $startDate->copy()->addDays($i);
            $pengeluaranHarian->push([
                'tanggal' => $tanggal->format('Y-m-d'),
                'total_pengeluaran' => $pengeluaranPerHari
            ]);
        }

        return $pengeluaranHarian;
    }

    private function getProdukTerlarisByProfit($startDate, $endDate)
    {
        return DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.status', 'completed')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select(
                'products.nama',
                DB::raw('SUM(order_items.quantity) as total_terjual'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_pendapatan')
            )
            ->groupBy('products.id', 'products.nama')
            ->orderBy('total_pendapatan', 'desc')
            ->limit(5)
            ->get();
    }

    private function getKategoriTerlarisByProfit($startDate, $endDate)
    {
        return DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('orders.status', 'completed')
            ->whereBetween('orders.created_at', [$startDate, $endDate])
            ->select(
                'categories.name as kategori',
                DB::raw('SUM(order_items.quantity) as total_terjual'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_pendapatan')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_pendapatan', 'desc')
            ->limit(5)
            ->get();
    }

    private function getProfitHarian($startDate, $endDate)
    {
        $penjualanHarian = Order::where('status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('SUM(total) as total_pendapatan')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        return $penjualanHarian->map(function($item) {
            $estimasiCost = $item->total_pendapatan * 0.7; // Estimasi 70% cost
            return [
                'tanggal' => $item->tanggal,
                'total_profit' => $item->total_pendapatan - $estimasiCost
            ];
        });
    }

    private function estimasiPembelianAset($startDate, $endDate)
    {
        // Estimasi pembelian aset tetap
        return 1000000; // 1 juta per periode
    }

    private function estimasiPinjaman($startDate, $endDate)
    {
        // Estimasi pinjaman baru
        return 0; // Tidak ada pinjaman baru
    }

    private function estimasiPembayaranPinjaman($startDate, $endDate)
    {
        // Estimasi pembayaran pinjaman
        return 500000; // 500 ribu per periode
    }

    private function hitungPersentasePerubahan($nilaiSekarang, $nilaiSebelumnya)
    {
        if ($nilaiSebelumnya == 0) {
            return $nilaiSekarang > 0 ? 100 : 0;
        }
        return (($nilaiSekarang - $nilaiSebelumnya) / $nilaiSebelumnya) * 100;
    }
}
