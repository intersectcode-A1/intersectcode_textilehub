<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Expense;
use App\Models\ExpenseCategory;
use App\Models\User;

class ExpenseSeeder extends Seeder
{
    public function run(): void
    {
        $categories = ExpenseCategory::all();
        $users = User::where('role', 'admin')->get();
        
        if ($users->isEmpty()) {
            $users = User::all();
        }

        if ($users->isEmpty()) {
            return;
        }

        $expenses = [
            [
                'category_name' => 'Pembelian Stok',
                'nominal' => 5000000,
                'tanggal' => now()->subDays(30),
                'deskripsi' => 'Pembelian stok benang dari supplier utama'
            ],
            [
                'category_name' => 'Operasional',
                'nominal' => 500000,
                'tanggal' => now()->subDays(25),
                'deskripsi' => 'Biaya listrik dan internet bulan ini'
            ],
            [
                'category_name' => 'Gaji Karyawan',
                'nominal' => 2000000,
                'tanggal' => now()->subDays(20),
                'deskripsi' => 'Gaji karyawan bulan ini'
            ],
            [
                'category_name' => 'Marketing',
                'nominal' => 300000,
                'tanggal' => now()->subDays(15),
                'deskripsi' => 'Biaya iklan di media sosial'
            ],
            [
                'category_name' => 'Transportasi',
                'nominal' => 150000,
                'tanggal' => now()->subDays(10),
                'deskripsi' => 'Biaya pengiriman ke pelanggan'
            ],
            [
                'category_name' => 'Maintenance',
                'nominal' => 250000,
                'tanggal' => now()->subDays(5),
                'deskripsi' => 'Perbaikan mesin jahit'
            ],
            [
                'category_name' => 'Pajak',
                'nominal' => 750000,
                'tanggal' => now()->subDays(2),
                'deskripsi' => 'Pembayaran pajak bulanan'
            ],
            [
                'category_name' => 'Pembelian Stok',
                'nominal' => 3000000,
                'tanggal' => now()->subDays(1),
                'deskripsi' => 'Pembelian kain dari supplier'
            ]
        ];

        foreach ($expenses as $expenseData) {
            $category = $categories->where('nama', $expenseData['category_name'])->first();
            
            if ($category) {
                Expense::create([
                    'expense_category_id' => $category->id,
                    'nominal' => $expenseData['nominal'],
                    'tanggal' => $expenseData['tanggal'],
                    'deskripsi' => $expenseData['deskripsi'],
                    'user_id' => $users->random()->id,
                ]);
            }
        }
    }
} 