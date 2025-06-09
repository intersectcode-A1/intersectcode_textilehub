<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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

        DB::table('products')->insert([
            'nama' => 'Kain Katun Premium',
            'harga' => 50000,
            'stok' => 100,
            'deskripsi' => 'Kain katun berkualitas tinggi',
            'category_id' => 1,
            'satuan' => 'meter',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('products')->insert([
            'nama' => 'Kain Sutra',
            'harga' => 150000,
            'stok' => 50,
            'deskripsi' => 'Kain sutra halus',
            'category_id' => 1,
            'satuan' => 'meter',
            'created_at' => now(),
            'updated_at' => now()
        ]);

        DB::table('products')->insert([
            [
                'nama' => 'wol',
                'harga' => 150000,
                'stok' => 24,
                'deskripsi' => 'jnknk',
                'foto' => 'produk/0NN3NixuFzmoPgShwaQcUcjFrFD8h4xhi',
                'category_id' => 1, // pastikan ID kategori ini sudah ada (misalnya dari CategorySeeder)
                'unit_id' => 1,
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
                'unit_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
