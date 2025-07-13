<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Database\Seeders\ProductSeeder;
use Database\Seeders\UnitSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
{
    if (!User::where('email', 'admin@gmail.com')->exists()) {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'admin',
        ]);
    }

    // Tambahkan user kasir
    if (!User::where('email', 'kasir@gmail.com')->exists()) {
        User::factory()->create([
            'name' => 'Kasir',
            'email' => 'kasir@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'kasir',
        ]);
    }
    // Tambahkan user gudang
    if (!User::where('email', 'gudang@gmail.com')->exists()) {
        User::factory()->create([
            'name' => 'Gudang',
            'email' => 'gudang@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'gudang',
        ]);
    }
    // Tambahkan user owner
    if (!User::where('email', 'owner@gmail.com')->exists()) {
        User::factory()->create([
            'name' => 'Owner',
            'email' => 'owner@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'owner',
        ]);
    }
    // Tambahkan user karyawan
    if (!User::where('email', 'karyawan@gmail.com')->exists()) {
        User::factory()->create([
            'name' => 'Karyawan',
            'email' => 'karyawan@gmail.com',
            'password' => Hash::make('admin'),
            'role' => 'karyawan',
        ]);
    }

    // Panggil seeder kategori dulu
    $this->call([
        CategorySeeder::class,
        UnitSeeder::class,
        ProductSeeder::class,
    ]);
}

}