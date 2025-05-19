<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class TrackingSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('trackings')->insert([
            [
                'order_number' => 'INV123456',
                'status' => 'Sedang dikirim',
                'description' => 'Kurir sedang dalam perjalanan mengantarkan barang.',
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ],
        ]);
            $this->call(TrackingSeeder::class);

    }
}
