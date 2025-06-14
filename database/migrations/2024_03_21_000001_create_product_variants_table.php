<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('name'); // Nama varian (misalnya: "Merah", "XL", dll)
            $table->enum('type', ['color', 'size']); // Tipe varian (warna atau ukuran)
            $table->integer('stock')->default(0); // Stok per varian
            $table->decimal('additional_price', 10, 2)->default(0); // Harga tambahan jika ada
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_variants');
    }
}; 