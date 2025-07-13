<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Font;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Carbon\Carbon;

class SalesAnalysisExport implements WithMultipleSheets
{
    protected $period;
    protected $startDate;
    protected $endDate;
    protected $data;

    public function __construct($period = 7, $data = [])
    {
        $this->period = $period;
        $this->endDate = Carbon::now();
        $this->startDate = Carbon::now()->subDays($period);
        $this->data = $data;
    }

    public function sheets(): array
    {
        return [
            'Ringkasan' => new SalesSummarySheet($this->period, $this->data),
            'Penjualan Harian' => new DailySalesSheet($this->startDate, $this->endDate),
            'Produk Terlaris' => new TopProductsSheet($this->startDate, $this->endDate),
            'Penjualan per Kategori' => new CategorySalesSheet($this->startDate, $this->endDate),
        ];
    }
}

class SalesSummarySheet implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
{
    protected $period;
    protected $data;

    public function __construct($period, $data)
    {
        $this->period = $period;
        $this->data = $data;
    }

    public function collection()
    {
        $periodText = match($this->period) {
            7 => '7 Hari Terakhir',
            30 => '30 Hari Terakhir',
            90 => '3 Bulan Terakhir',
            365 => '1 Tahun Terakhir',
            default => $this->period . ' Hari Terakhir'
        };

        return collect([
            ['LAPORAN ANALISIS PENJUALAN', '', '', ''],
            ['Periode', $periodText, '', ''],
            ['Tanggal Export', Carbon::now()->format('d/m/Y H:i'), '', ''],
            ['Dibuat oleh', 'Sistem Analisis Penjualan', '', ''],
            ['', '', '', ''],
            ['METRIK UTAMA', '', '', ''],
            ['Total Penjualan', 'Rp ' . number_format($this->data['totalPenjualan'] ?? 0, 0, ',', '.'), '', ''],
            ['Jumlah Transaksi', (string)($this->data['jumlahTransaksi'] ?? 0), '', ''],
            ['Rata-rata Transaksi', 'Rp ' . number_format($this->data['rataRataTransaksi'] ?? 0, 0, ',', '.'), '', ''],
            ['', '', '', ''],
            ['PERTUMBUHAN (vs Periode Sebelumnya)', '', '', ''],
            ['Pertumbuhan Penjualan', number_format($this->data['persentasePertumbuhan'] ?? 0, 1) . '%', '', ''],
            ['Pertumbuhan Transaksi', number_format($this->data['persentaseTransaksi'] ?? 0, 1) . '%', '', ''],
            ['Pertumbuhan Rata-rata', number_format($this->data['persentaseRataRata'] ?? 0, 1) . '%', '', ''],
            ['', '', '', ''],
            ['CATATAN', '', '', ''],
            ['• Data diambil dari pesanan dengan status "completed"', '', '', ''],
            ['• Periode sebelumnya dihitung berdasarkan periode yang dipilih', '', '', ''],
            ['• Pertumbuhan dihitung dengan rumus: ((Saat Ini - Sebelumnya) / Sebelumnya) × 100', '', '', ''],
        ]);
    }

    public function headings(): array
    {
        return ['', '', '', ''];
    }

    public function styles(Worksheet $sheet)
    {
        // Merge cell judul
        $sheet->mergeCells('A1:D1');
        // Section title METRIK UTAMA
        $sheet->mergeCells('A6:D6');
        // Section title PERTUMBUHAN
        $sheet->mergeCells('A10:D10');
        // Section title CATATAN
        $sheet->mergeCells('A15:D15');

        // Border untuk seluruh area utama
        $sheet->getStyle('A1:D18')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Alignment tengah untuk judul dan section
        $sheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A6')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A10')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
        $sheet->getStyle('A15')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

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
        // Section PERTUMBUHAN
        $sheet->getStyle('A10')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFFDE7']],
        ]);
        // Section CATATAN
        $sheet->getStyle('A15')->applyFromArray([
            'font' => ['bold' => true, 'size' => 14],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E1F5FE']],
        ]);
        // Label bold
        $sheet->getStyle('A2:A4')->getFont()->setBold(true);
        $sheet->getStyle('A7:A9')->getFont()->setBold(true);
        $sheet->getStyle('A11:A13')->getFont()->setBold(true);
        // Value warna berbeda
        $sheet->getStyle('B7:B9')->getFont()->getColor()->setRGB('1976D2'); // biru
        $sheet->getStyle('B11:B13')->getFont()->getColor()->setRGB('388E3C'); // hijau
        // Catatan warna hijau dan italic
        $sheet->getStyle('A16:A18')->applyFromArray([
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
}

class DailySalesSheet implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
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
        $dailySales = \App\Models\Order::where('status', 'completed')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->select(
                \Illuminate\Support\Facades\DB::raw('DATE(created_at) as tanggal'),
                \Illuminate\Support\Facades\DB::raw('COUNT(*) as jumlah_transaksi'),
                \Illuminate\Support\Facades\DB::raw('SUM(total) as total_penjualan'),
                \Illuminate\Support\Facades\DB::raw('AVG(total) as rata_rata_transaksi')
            )
            ->groupBy('tanggal')
            ->orderBy('tanggal')
            ->get();

        return $dailySales->map(function ($item) {
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
        return [
            'Tanggal',
            'Jumlah Transaksi',
            'Total Penjualan',
            'Rata-rata Transaksi'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E3F2FD']],
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

class TopProductsSheet implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
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
        $orderIds = \App\Models\Order::where('status', 'completed')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->pluck('id');

        if ($orderIds->isEmpty()) {
            return collect();
        }

        $topProducts = \Illuminate\Support\Facades\DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->whereIn('order_items.order_id', $orderIds)
            ->whereNotNull('products.category_id')
            ->select(
                'products.nama as nama',
                'categories.name as kategori',
                \Illuminate\Support\Facades\DB::raw('SUM(order_items.quantity) as jumlah_terjual'),
                \Illuminate\Support\Facades\DB::raw('SUM(order_items.quantity * order_items.price) as total_penjualan'),
                \Illuminate\Support\Facades\DB::raw('AVG(order_items.price) as harga_rata_rata')
            )
            ->groupBy('products.id', 'products.nama', 'categories.name')
            ->orderBy('jumlah_terjual', 'desc')
            ->limit(20)
            ->get();

        return $topProducts->map(function ($item, $index) {
            return [
                $index + 1,
                $item->nama,
                $item->kategori,
                $item->jumlah_terjual,
                'Rp ' . number_format($item->harga_rata_rata, 0, ',', '.'),
                'Rp ' . number_format($item->total_penjualan, 0, ',', '.'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Ranking',
            'Nama Produk',
            'Kategori',
            'Jumlah Terjual',
            'Harga Rata-rata',
            'Total Penjualan'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'E8F5E8']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 10,
            'B' => 30,
            'C' => 20,
            'D' => 15,
            'E' => 20,
            'F' => 25,
        ];
    }

    public function title(): string
    {
        return 'Produk Terlaris';
    }
}

class CategorySalesSheet implements FromCollection, WithHeadings, WithStyles, WithColumnWidths, WithTitle
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
        $orderIds = \App\Models\Order::where('status', 'completed')
            ->whereBetween('created_at', [$this->startDate, $this->endDate])
            ->pluck('id');

        if ($orderIds->isEmpty()) {
            return collect();
        }

        $categorySales = \Illuminate\Support\Facades\DB::table('order_items')
            ->join('products', 'order_items.product_id', '=', 'products.id')
            ->join('categories', 'products.category_id', '=', 'categories.id')
            ->whereIn('order_items.order_id', $orderIds)
            ->whereNotNull('products.category_id')
            ->select(
                'categories.name as kategori',
                \Illuminate\Support\Facades\DB::raw('COUNT(DISTINCT order_items.order_id) as jumlah_transaksi'),
                \Illuminate\Support\Facades\DB::raw('SUM(order_items.quantity) as total_quantity'),
                \Illuminate\Support\Facades\DB::raw('SUM(order_items.quantity * order_items.price) as total_penjualan'),
                \Illuminate\Support\Facades\DB::raw('AVG(order_items.quantity * order_items.price) as rata_rata_transaksi')
            )
            ->groupBy('categories.id', 'categories.name')
            ->orderBy('total_penjualan', 'desc')
            ->get();

        return $categorySales->map(function ($item) {
            return [
                $item->kategori,
                $item->jumlah_transaksi,
                $item->total_quantity,
                'Rp ' . number_format($item->total_penjualan, 0, ',', '.'),
                'Rp ' . number_format($item->rata_rata_transaksi, 0, ',', '.'),
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Kategori',
            'Jumlah Transaksi',
            'Total Quantity',
            'Total Penjualan',
            'Rata-rata per Transaksi'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => 'FFF3E0']],
                'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
            ],
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 25,
            'B' => 20,
            'C' => 20,
            'D' => 25,
            'E' => 25,
        ];
    }

    public function title(): string
    {
        return 'Penjualan per Kategori';
    }
} 