<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use Illuminate\Support\Str;
use App\Models\ProductVariant;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // Pastikan ada unit dengan ID 1 (misalnya 'Pcs')
        if (!DB::table('units')->where('id', 1)->exists()) {
            DB::table('units')->insert([
                'id' => 1,
                'name' => 'Pieces',
                'symbol' => 'Pcs',
                'description' => 'Satuan per pieces/buah',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Hapus data terkait sebelum truncate products
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('inventory_logs')->truncate();
        DB::table('order_items')->truncate();
        DB::table('orders')->truncate();
        Product::truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        // Daftar kategori relevan
        $kategoriRelevan = [
            'Kain', 'Kancing', 'Mesin Jahit', 'Pita', 'Alat Mesin', 'Minyak Mesin', 'Benang', 'Renda', 'Aksesoris', 'Perlengkapan Jahit', 'Peralatan Lainnya'
        ];
        // Pastikan kategori relevan ada di database
        $categoryIds = [];
        foreach ($kategoriRelevan as $kategori) {
            $cat = Category::firstOrCreate(['name' => $kategori]);
            $categoryIds[] = $cat->id;
        }
        $suppliers = Supplier::pluck('id')->toArray();
        $satuanList = ['pcs', 'kg', 'meter', 'roll', 'pak'];
        $faker = \Faker\Factory::create('id_ID');
        $now = now();
        $startDate = $now->copy()->subMonths(3);
        $variantTypes = ['color', 'size'];
        $variantNames = [
            'color' => ['Merah', 'Biru', 'Hijau', 'Kuning', 'Hitam', 'Putih', 'Coklat', 'Ungu', 'Pink', 'Abu-abu'],
            'size' => ['S', 'M', 'L', 'XL', 'XXL', 'Jumbo', 'Mini']
        ];

        for ($i = 0; $i < 150; $i++) {
            $harga = $faker->numberBetween(20000, 1000000);
            $harga = round($harga, -3);
            $createdAt = $faker->dateTimeBetween($startDate, $now);
            $namaProduk = $faker->randomElement($kategoriRelevan) . ' ' . $faker->word;
            $product = Product::create([
                'nama' => $namaProduk,
                'harga' => $harga,
                'stok' => $faker->numberBetween(10, 200),
                'deskripsi' => $faker->sentence,
                'category_id' => $faker->randomElement($categoryIds),
                'supplier_id' => $faker->randomElement($suppliers),
                'satuan' => $faker->randomElement($satuanList),
                'unit_id' => 1,
                'discount' => $faker->randomElement([0, 5, 10, 15, 20]),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
            // Tambahkan varian (1-3 per produk)
            $variantCount = $faker->numberBetween(1, 3);
            for ($v = 0; $v < $variantCount; $v++) {
                $type = $faker->randomElement($variantTypes);
                $name = $faker->randomElement($variantNames[$type]);
                ProductVariant::create([
                    'product_id' => $product->id,
                    'name' => $name,
                    'type' => $type,
                    'stock' => $faker->numberBetween(5, 100),
                    'additional_price' => $faker->randomElement([0, 5000, 10000, 20000, 25000, 50000]),
                ]);
            }
        }
    }
}
