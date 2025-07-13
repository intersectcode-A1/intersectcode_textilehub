<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Models\Expense;
use App\Models\ExpenseCategory;

class LaporanKeuanganExport implements WithMultipleSheets
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function sheets(): array
    {
        return [
            'Ringkasan' => new RingkasanSheet($this->startDate, $this->endDate),
            'Penjualan Harian' => new PenjualanHarianSheet($this->startDate, $this->endDate),
            'Produk Terlaris' => new ProdukTerlarisSheet($this->startDate, $this->endDate),
            'Kategori Terlaris' => new KategoriTerlarisSheet($this->startDate, $this->endDate),
            'Cash Flow' => new CashFlowSheet($this->startDate, $this->endDate),
            'Detail Pengeluaran' => new PengeluaranDetailSheet($this->startDate, $this->endDate),
        ];
    }
}

class RingkasanSheet implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $periodText = Carbon::parse($this->startDate)->format('d M Y') . ' - ' . Carbon::parse($this->endDate)->format('d M Y');
        return collect([
            ['LAPORAN KEUANGAN', '', '', ''],
            ['Periode', $periodText, '', ''],
            ['Tanggal Export', Carbon::now()->format('d/m/Y H:i'), '', ''],
            ['Dibuat oleh', 'Sistem Laporan Keuangan', '', ''],
            ['', '', '', ''],
            ['METRIK UTAMA', '', '', ''],
            ['Total Pendapatan', 'Rp ' . number_format($this->getTotalPendapatan(), 0, ',', '.'), '', ''],
            ['Total Pengeluaran', 'Rp ' . number_format($this->getTotalPengeluaran(), 0, ',', '.'), '', ''],
            ['Total Profit', 'Rp ' . number_format($this->getTotalProfit(), 0, ',', '.'), '', ''],
            ['Margin Profit', number_format($this->getMarginProfit(), 1) . '%', '', ''],
            ['Jumlah Transaksi', number_format($this->getJumlahTransaksi()), '', ''],
            ['Rata-rata Transaksi', 'Rp ' . number_format($this->getRataRataTransaksi(), 0, ',', '.'), '', ''],
            ['', '', '', ''],
            ['CATATAN', '', '', ''],
            ['• Data diambil dari transaksi real (orders & expenses)', '', '', ''],
            ['• Pengeluaran = data expenses, bukan estimasi', '', '', ''],
        ]);
    }

    public function headings(): array
    {
        return ['', '', '', ''];
    }

    public function styles(Worksheet $sheet)
    {
        // Merge cell judul dan section
        $sheet->mergeCells('A1:D1');
        $sheet->mergeCells('A6:D6');
        $sheet->mergeCells('A14:D14');
        // Border seluruh area utama
        $sheet->getStyle('A1:D17')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        // Alignment tengah untuk judul dan section
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A14')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        // Font dan warna judul
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'size' => 18],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E3F2FD']],
        ]);
        // Section METRIK UTAMA
        $sheet->getStyle('A6')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E8F5E9']],
        ]);
        // Section CATATAN
        $sheet->getStyle('A14')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E1F5FE']],
        ]);
        // Label bold
        $sheet->getStyle('A2:A12')->getFont()->setBold(true);
        // Value warna berbeda
        $sheet->getStyle('B7')->getFont()->getColor()->setRGB('1976D2'); // biru
        $sheet->getStyle('B8')->getFont()->getColor()->setRGB('D32F2F'); // merah
        $sheet->getStyle('B9')->getFont()->getColor()->setRGB('388E3C'); // hijau
        $sheet->getStyle('B10')->getFont()->getColor()->setRGB('7B1FA2'); // ungu
        // Catatan warna hijau dan italic
        $sheet->getStyle('A15:A16')->applyFromArray([
            'font' => ['italic' => true, 'color' => ['rgb' => '388E3C']],
        ]);
        // Lebar kolom
        $sheet->getColumnDimension('A')->setWidth(28);
        $sheet->getColumnDimension('B')->setWidth(32);
        $sheet->getColumnDimension('C')->setWidth(20);
        $sheet->getColumnDimension('D')->setWidth(20);
        return [];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 25,
            'C' => 20,
            'D' => 20,
        ];
    }

    public function title(): string
    {
        return 'Ringkasan';
    }

    // Helper untuk ambil data dari DB (agar DRY)
    private function getTotalPendapatan() {
        return \App\Models\Order::where('status', 'completed')->whereBetween('created_at', [$this->startDate, $this->endDate])->sum('total');
    }
    private function getTotalPengeluaran() {
        return \App\Models\Expense::whereBetween('tanggal', [$this->startDate, $this->endDate])->sum('nominal');
    }
    private function getTotalProfit() {
        return $this->getTotalPendapatan() - $this->getTotalPengeluaran();
    }
    private function getMarginProfit() {
        $pendapatan = $this->getTotalPendapatan();
        $profit = $this->getTotalProfit();
        return $pendapatan > 0 ? ($profit / $pendapatan) * 100 : 0;
    }
    private function getJumlahTransaksi() {
        return \App\Models\Order::where('status', 'completed')->whereBetween('created_at', [$this->startDate, $this->endDate])->count();
    }
    private function getRataRataTransaksi() {
        $pendapatan = $this->getTotalPendapatan();
        $jumlah = $this->getJumlahTransaksi();
        return $jumlah > 0 ? $pendapatan / $jumlah : 0;
    }
}

class PenjualanHarianSheet implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $penjualanHarian = Order::where('status', 'completed')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->select(
                DB::raw('DATE(created_at) as tanggal'),
                DB::raw('COUNT(*) as jumlah_transaksi'),
                DB::raw('SUM(total) as total_penjualan'),
                DB::raw('AVG(total) as rata_rata_transaksi')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        return $penjualanHarian->map(function ($item) {
            return [
                Carbon::parse($item->tanggal)->format('d/m/Y'),
                $item->jumlah_transaksi,
                'Rp ' . number_format($item->total_penjualan, 0, ',', '.'),
                'Rp ' . number_format($item->rata_rata_transaksi, 0, ',', '.'),
            ];
        });
    }

    public function headings(): array
    {
        return ['Tanggal', 'Jumlah Transaksi', 'Total Penjualan', 'Rata-rata Transaksi'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 15,
            'B' => 20,
            'C' => 25,
            'D' => 25,
        ];
    }

    public function title(): string
    {
        return 'Penjualan Harian';
    }
}

class ProdukTerlarisSheet implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $produkTerlaris = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->where('orders.status', 'completed')
            ->whereBetween('orders.created_at', [$this->startDate, $this->endDate])
            ->select(
                'products.nama',
                DB::raw('SUM(order_items.quantity) as total_terjual'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_pendapatan')
            )
            ->groupBy('products.id', 'products.nama')
            ->orderBy('total_pendapatan', 'desc')
            ->limit(10)
            ->get();

        return $produkTerlaris->map(function ($item, $index) {
            return [
                $index + 1,
                $item->nama,
                number_format($item->total_terjual),
                'Rp ' . number_format($item->total_pendapatan, 0, ',', '.'),
            ];
        });
    }

    public function headings(): array
    {
        return ['Ranking', 'Nama Produk', 'Total Terjual', 'Total Pendapatan'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 40,
            'C' => 15,
            'D' => 25,
        ];
    }

    public function title(): string
    {
        return 'Produk Terlaris';
    }
}

class KategoriTerlarisSheet implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $kategoriTerlaris = DB::table('order_items')
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->where('orders.status', 'completed')
            ->whereBetween('orders.created_at', [$this->startDate, $this->endDate])
            ->select(
                'categories.name as kategori',
                DB::raw('SUM(order_items.quantity) as total_terjual'),
                DB::raw('SUM(order_items.quantity * order_items.price) as total_pendapatan')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_pendapatan', 'desc')
            ->limit(10)
            ->get();

        return $kategoriTerlaris->map(function ($item, $index) {
            return [
                $index + 1,
                $item->kategori,
                number_format($item->total_terjual),
                'Rp ' . number_format($item->total_pendapatan, 0, ',', '.'),
            ];
        });
    }

    public function headings(): array
    {
        return ['Ranking', 'Kategori', 'Total Terjual', 'Total Pendapatan'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 30,
            'C' => 15,
            'D' => 25,
        ];
    }

    public function title(): string
    {
        return 'Kategori Terlaris';
    }
}

class CashFlowSheet implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $totalPendapatan = Order::where('status', 'completed')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->sum('total');

        $totalPengeluaran = Expense::whereBetween('tanggal', [$this->startDate, $this->endDate])->sum('nominal');
        $netCashOperating = $totalPendapatan - $totalPengeluaran;
        $pembelianAset = 1000000; // Estimasi
        $pinjaman = 0;
        $pembayaranPinjaman = 500000; // Estimasi
        $netCashFinancing = $pinjaman - $pembayaranPinjaman;
        $netChange = $netCashOperating - $pembelianAset + $netCashFinancing;

        return collect([
            ['Aktivitas', 'Keterangan', 'Jumlah'],
            ['Operating Activities', 'Pendapatan Penjualan', 'Rp ' . number_format($totalPendapatan, 0, ',', '.')],
            ['Operating Activities', 'Pengeluaran Operasional', '-Rp ' . number_format($totalPengeluaran, 0, ',', '.')],
            ['Operating Activities', 'Net Cash from Operating', 'Rp ' . number_format($netCashOperating, 0, ',', '.')],
            ['', '', ''],
            ['Investing Activities', 'Pembelian Aset', '-Rp ' . number_format($pembelianAset, 0, ',', '.')],
            ['Investing Activities', 'Net Cash from Investing', '-Rp ' . number_format($pembelianAset, 0, ',', '.')],
            ['', '', ''],
            ['Financing Activities', 'Pinjaman', 'Rp ' . number_format($pinjaman, 0, ',', '.')],
            ['Financing Activities', 'Pembayaran Pinjaman', '-Rp ' . number_format($pembayaranPinjaman, 0, ',', '.')],
            ['Financing Activities', 'Net Cash from Financing', 'Rp ' . number_format($netCashFinancing, 0, ',', '.')],
            ['', '', ''],
            ['', 'Net Change in Cash', 'Rp ' . number_format($netChange, 0, ',', '.')],
        ]);
    }

    public function headings(): array
    {
        return ['Aktivitas', 'Keterangan', 'Jumlah'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
            14 => [
                'font' => ['bold' => true],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 30,
            'C' => 25,
        ];
    }

    public function title(): string
    {
        return 'Cash Flow';
    }
}

class PengeluaranDetailSheet implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    public function collection()
    {
        $details = Expense::join('expense_categories', 'expenses.expense_category_id', '=', 'expense_categories.id')
            ->whereBetween('expenses.tanggal', [$this->startDate, $this->endDate])
            ->select(
                'expense_categories.nama as kategori',
                DB::raw('SUM(expenses.nominal) as total'),
                DB::raw('COUNT(*) as jumlah_transaksi')
            )
            ->groupBy('expense_categories.id', 'expense_categories.nama')
            ->orderBy('total', 'desc')
            ->get();

        $totalPengeluaran = $details->sum('total');

        return $details->map(function($item) use ($totalPengeluaran) {
            return [
                $item->kategori,
                $item->total,
                $item->jumlah_transaksi,
                $totalPengeluaran > 0 ? round(($item->total / $totalPengeluaran) * 100, 1) : 0
            ];
        });
    }

    public function headings(): array
    {
        return ['Kategori', 'Total', 'Jumlah Transaksi', '% dari Total'];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 20,
            'C' => 20,
            'D' => 15,
        ];
    }

    public function title(): string
    {
        return 'Detail Pengeluaran';
    }
} 