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
        Schema::create('produks', function (Blueprint $table) {
            $table->increments('id_produk');
            $table->unsignedInteger('id_kategori');
            $table->string('kode_produk')->unique();
            $table->string('nama_produk')->unique();
            $table->integer('harga_modal');
            $table->tinyInteger('diskon')->default(0);
            $table->integer('harga_jual');
            $table->timestamps();

            $table->foreign('id_kategori')->references('id_kategori')->on('kategoris')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produks');
    }
};
