<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Supplier;
use Illuminate\Support\Str;
use Carbon\Carbon;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        $now = Carbon::now();
        $startDate = $now->copy()->subMonths(3);

        for ($i = 0; $i < 300; $i++) {
            $createdAt = $faker->dateTimeBetween($startDate, $now);
            Supplier::create([
                'nama' => $faker->company,
                'alamat' => $faker->address,
                'kontak' => $faker->phoneNumber,
                'produk' => $faker->word,
                'harga_modal' => $faker->randomFloat(2, 10000, 1000000),
                'deskripsi' => $faker->sentence,
                'satuan' => $faker->randomElement(['pcs', 'kg', 'meter', 'roll', 'pak']),
                'created_at' => $createdAt,
                'updated_at' => $createdAt,
            ]);
        }
    }
} 