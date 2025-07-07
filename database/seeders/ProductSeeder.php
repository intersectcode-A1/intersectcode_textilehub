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
    }
}
