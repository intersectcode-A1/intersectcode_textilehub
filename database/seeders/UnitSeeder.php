<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        $units = [
            [
                'name' => 'Lusin',
                'symbol' => 'Lsn',
                'description' => '1 Lusin = 12 Pcs'
            ],
            [
                'name' => 'Kodi',
                'symbol' => 'Kd',
                'description' => '1 Kodi = 20 Pcs'
            ],
            [
                'name' => 'Pieces',
                'symbol' => 'Pcs',
                'description' => 'Satuan per item'
            ],
            [
                'name' => 'Meter',
                'symbol' => 'm',
                'description' => 'Satuan panjang'
            ],
            [
                'name' => 'Roll',
                'symbol' => 'Rol',
                'description' => 'Satuan dalam bentuk gulungan'
            ],
            [
                'name' => 'Pack',
                'symbol' => 'Pak',
                'description' => 'Satuan dalam bentuk kemasan'
            ],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
} 