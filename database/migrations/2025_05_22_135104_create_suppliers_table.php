<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuppliersTable extends Migration
{
   public function up()
{
    Schema::create('suppliers', function (Blueprint $table) {
        $table->id();
        $table->string('nama');
        $table->text('alamat');
        $table->string('kontak');
        $table->string('produk');
        $table->decimal('harga_modal', 15, 2)->default(0);
        $table->text('deskripsi')->nullable();
        $table->timestamps();
    });
}


    public function down()
    {
        Schema::dropIfExists('suppliers');
    }
};
