<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('product_variants', function (Blueprint $table) {
            $table->string('type', 50)->change();
        });
    }

    public function down()
    {
        Schema::table('product_variants', function (Blueprint $table) {
            // Kembalikan ke enum jika perlu (hati-hati, data yang tidak sesuai enum akan error)
            $table->enum('type', ['color', 'size'])->change();
        });
    }
}; 