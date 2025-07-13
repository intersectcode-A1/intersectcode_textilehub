<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ExpenseCategory;

class ExpenseCategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'nama' => 'Pembelian Stok',
                'deskripsi' => 'Pengeluaran untuk pembelian produk dari supplier'
            ],
            [
                'nama' => 'Operasional',
                'deskripsi' => 'Biaya operasional sehari-hari seperti listrik, air, internet'
            ],
            [
                'nama' => 'Gaji Karyawan',
                'deskripsi' => 'Pengeluaran untuk gaji dan tunjangan karyawan'
            ],
            [
                'nama' => 'Marketing',
                'deskripsi' => 'Biaya promosi, iklan, dan pemasaran'
            ],
            [
                'nama' => 'Transportasi',
                'deskripsi' => 'Biaya transportasi dan pengiriman'
            ],
            [
                'nama' => 'Maintenance',
                'deskripsi' => 'Biaya perbaikan dan pemeliharaan peralatan'
            ],
            [
                'nama' => 'Pajak',
                'deskripsi' => 'Pembayaran pajak dan retribusi'
            ],
            [
                'nama' => 'Lainnya',
                'deskripsi' => 'Pengeluaran lain-lain yang tidak masuk kategori di atas'
            ]
        ];

        foreach ($categories as $category) {
            ExpenseCategory::create($category);
        }
    }
} 