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
        Schema::table('suppliers', function (Blueprint $table) {
            if (!Schema::hasColumn('suppliers', 'harga_modal')) {
                $table->decimal('harga_modal', 15, 2)->default(0);
            }
            if (!Schema::hasColumn('suppliers', 'deskripsi')) {
                $table->text('deskripsi')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('suppliers', function (Blueprint $table) {
            if (Schema::hasColumn('suppliers', 'harga_modal')) {
                $table->dropColumn('harga_modal');
            }
            if (Schema::hasColumn('suppliers', 'deskripsi')) {
                $table->dropColumn('deskripsi');
            }
        });
    }
};
