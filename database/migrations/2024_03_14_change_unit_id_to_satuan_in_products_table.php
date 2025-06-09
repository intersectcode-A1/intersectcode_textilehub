<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            // Hapus kolom unit_id
            $table->dropColumn('unit_id');
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            // Kembalikan kolom unit_id
            $table->foreignId('unit_id')->after('category_id')->constrained();
        });
    }
}; 