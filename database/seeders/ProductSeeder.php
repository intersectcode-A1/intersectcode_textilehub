<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    public function run()
    {
        DB::table('products')->insert([
            [
                'nama' => 'wol',
                'harga' => 150000,
                'stok' => 24,
                'deskripsi' => 'jnknk',
                'foto' => 'produk/0NN3NixuFzmoPgShwaQcUcjFrFD8h4xhi',
                'category_id' => 1, // pastikan ID kategori ini sudah ada (misalnya dari CategorySeeder)
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'AKBAR HIDAYATULLAH',
                'harga' => 200000,
                'stok' => 34,
                'deskripsi' => 'akbar gemoy nan lucu',
                'foto' => 'produk/ONLytqCXSOqaR6PlRkC6KRrCnSBBMC...', 
                'category_id' => 1, // sama juga, pakai kategori yang valid
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
