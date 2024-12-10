<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('produk', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_id')->constrained('kategori')->index(); // Tambahkan index
            $table->string('nama')->index(); // Tambahkan index
            $table->double('harga');
            $table->text('foto_produk');
            $table->text('deskripsi');
            $table->double('berat')->nullable(); // Tambahkan kolom berat produk
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produk');
    }
};