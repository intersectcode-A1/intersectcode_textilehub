<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventory_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['in', 'out']); // in = barang masuk, out = barang keluar
            $table->integer('quantity'); // jumlah barang
            $table->integer('stock_before'); // stok sebelum perubahan
            $table->integer('stock_after'); // stok setelah perubahan
            $table->text('description')->nullable(); // keterangan (misal: pembelian, penjualan, retur)
            $table->string('reference_type')->nullable(); // tipe referensi (order, purchase, adjustment)
            $table->unsignedBigInteger('reference_id')->nullable(); // ID referensi
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null'); // user yang melakukan
            $table->timestamps();
            
            // Index untuk performa query
            $table->index(['product_id', 'type', 'created_at']);
            $table->index(['type', 'created_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_logs');
    }
};
