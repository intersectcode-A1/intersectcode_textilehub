<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\InventoryLog;
use App\Models\Product;
use Carbon\Carbon;

class InventoryLogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = Product::all();
        
        if ($products->isEmpty()) {
            $this->command->info('Tidak ada produk untuk membuat log inventory.');
            return;
        }

        // Buat log untuk 30 hari terakhir
        for ($i = 30; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            
            foreach ($products as $product) {
                // Random log untuk setiap produk
                if (rand(1, 3) === 1) { // 33% chance untuk membuat log
                    $type = rand(1, 2) === 1 ? 'in' : 'out';
                    $quantity = rand(1, 10);
                    
                    if ($type === 'in') {
                        // Barang masuk
                        InventoryLog::create([
                            'product_id' => $product->id,
                            'type' => 'in',
                            'quantity' => $quantity,
                            'stock_before' => $product->stok,
                            'stock_after' => $product->stok + $quantity,
                            'description' => 'Pembelian stok dari supplier',
                            'reference_type' => 'purchase',
                            'reference_id' => null,
                            'user_id' => null,
                            'created_at' => $date,
                            'updated_at' => $date
                        ]);
                        
                        // Update stok produk
                        $product->increment('stok', $quantity);
                    } else {
                        // Barang keluar (hanya jika stok mencukupi)
                        if ($product->stok >= $quantity) {
                            InventoryLog::create([
                                'product_id' => $product->id,
                                'type' => 'out',
                                'quantity' => $quantity,
                                'stock_before' => $product->stok,
                                'stock_after' => $product->stok - $quantity,
                                'description' => 'Penjualan produk',
                                'reference_type' => 'order',
                                'reference_id' => null,
                                'user_id' => null,
                                'created_at' => $date,
                                'updated_at' => $date
                            ]);
                            
                            // Update stok produk
                            $product->decrement('stok', $quantity);
                        }
                    }
                }
            }
        }

        $this->command->info('Inventory logs berhasil dibuat!');
    }
}
