<?php

namespace App\Exports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class StrategiHargaExport implements FromCollection, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Product::with('category')->get()->map(function($product) {
            $cost = $product->harga * 0.7;
            $margin = $product->harga > 0 ? (($product->harga - $cost) / $product->harga) * 100 : 0;
            $categoryAvg = $product->category ? Product::where('category_id', $product->category_id)->avg('harga') : $product->harga;
            $recommended = $categoryAvg ? round($categoryAvg * 1.1) : $product->harga;
            return [
                'nama_produk' => $product->nama,
                'kategori' => $product->category->nama ?? '-',
                'harga' => $product->harga,
                'margin' => round($margin, 1),
                'rekomendasi_harga' => $recommended
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Nama Produk',
            'Kategori',
            'Harga',
            'Margin (%)',
            'Rekomendasi Harga'
        ];
    }
}
