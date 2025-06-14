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
        Schema::table('price_histories', function (Blueprint $table) {
            $table->bigInteger('old_price')->change();
            $table->bigInteger('new_price')->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('price_histories', function (Blueprint $table) {
            $table->integer('old_price')->change();
            $table->integer('new_price')->change();
        });
    }
};
