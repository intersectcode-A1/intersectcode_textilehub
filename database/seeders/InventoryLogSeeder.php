<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\InventoryLog;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class InventoryLogSeeder extends Seeder
{
    public function run(): void
    {
        // Reset data log inventory
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('inventory_logs')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $products = Product::all();
        if ($products->isEmpty()) {
            $this->command->info('Tidak ada produk untuk membuat log inventory.');
            return;
        }

        $faker = \Faker\Factory::create('id_ID');
        $now = Carbon::now();
        $startDate = $now->copy()->subMonths(3);

        for ($i = 0; $i < 1000; $i++) {
            $product = $products->random();
            $type = $faker->randomElement(['in', 'out']);
            $quantity = $faker->numberBetween(1, 20);
            $date = $faker->dateTimeBetween($startDate, $now);
            $stockBefore = $product->stok;
            $stockAfter = $type === 'in' ? $stockBefore + $quantity : max(0, $stockBefore - $quantity);
            $desc = $type === 'in' ? 'Pembelian stok dari supplier' : 'Penjualan produk';
            $refType = $type === 'in' ? 'purchase' : 'order';

            // Cegah stok minus
            if ($type === 'out' && $product->stok < $quantity) {
                continue;
            }

            InventoryLog::create([
                'product_id' => $product->id,
                'type' => $type,
                'quantity' => $quantity,
                'stock_before' => $stockBefore,
                'stock_after' => $stockAfter,
                'description' => $desc,
                'reference_type' => $refType,
                'reference_id' => null,
                'user_id' => null,
                'created_at' => $date,
                'updated_at' => $date
            ]);

            // Update stok produk
            if ($type === 'in') {
                $product->increment('stok', $quantity);
            } else {
                $product->decrement('stok', $quantity);
            }
        }
    }
}
