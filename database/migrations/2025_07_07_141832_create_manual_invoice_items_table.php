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
        Schema::create('manual_invoice_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('manual_invoice_id')->constrained('manual_invoices')->onDelete('cascade');
            $table->string('product_name');
            $table->string('variant')->nullable();
            $table->integer('quantity');
            $table->bigInteger('price');
            $table->bigInteger('subtotal');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('manual_invoice_items');
    }
};
