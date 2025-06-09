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
                'nama' => 'Lusin',
                'simbol' => 'Lsn',
                'deskripsi' => '1 Lusin = 12 Pcs'
            ],
            [
                'nama' => 'Kodi',
                'simbol' => 'Kd',
                'deskripsi' => '1 Kodi = 20 Pcs'
            ],
            [
                'nama' => 'Pieces',
                'simbol' => 'Pcs',
                'deskripsi' => 'Satuan per item'
            ],
            [
                'nama' => 'Meter',
                'simbol' => 'm',
                'deskripsi' => 'Satuan panjang'
            ],
            [
                'nama' => 'Roll',
                'simbol' => 'Rol',
                'deskripsi' => 'Satuan dalam bentuk gulungan'
            ],
            [
                'nama' => 'Pack',
                'simbol' => 'Pak',
                'deskripsi' => 'Satuan dalam bentuk kemasan'
            ],
        ];

        foreach ($units as $unit) {
            Unit::create($unit);
        }
    }
} 