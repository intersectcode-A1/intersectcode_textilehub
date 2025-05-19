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
      Schema::create('tracking_histories', function (Blueprint $table) {
    $table->id();
    $table->foreignId('tracking_id')->constrained()->onDelete('cascade');
    $table->string('status');
    $table->text('deskripsi')->nullable();
    $table->timestamp('waktu');
    $table->timestamps();
});

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tracking_histories');
    }
};
