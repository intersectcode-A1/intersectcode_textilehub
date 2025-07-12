<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class StockReportExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::with(['category', 'variants'])->get();
    }

    public function map($product): array
    {
        // Get variants info
        $variantsInfo = '';
        $variantsStock = '';
        
        if ($product->variants && $product->variants->count() > 0) {
            $variantNames = [];
            $variantStocks = [];
            
            foreach ($product->variants as $variant) {
                $variantNames[] = $variant->name;
                $variantStocks[] = $variant->stock;
            }
            
            $variantsInfo = implode(', ', $variantNames);
            $variantsStock = implode(', ', $variantStocks);
        } else {
            $variantsInfo = 'Tidak ada';
            $variantsStock = '0';
        }

        return [
            $product->nama,
            $product->category->name ?? 'N/A',
            'Rp ' . number_format($product->harga, 0, ',', '.'),
            $product->satuan,
            $product->stok,
            $variantsInfo,
            $variantsStock,
        ];
    }

    public function headings(): array
    {
        return [
            'Nama Produk',
            'Kategori Produk',
            'Harga Produk',
            'Satuan Produk',
            'Stok Produk',
            'Varian',
            'Stok Varian'
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            // Style the first row as bold text
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                    'startColor' => ['rgb' => 'E3F2FD']
                ],
                'alignment' => [
                    'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                ]
            ],
        ];
    }
} 