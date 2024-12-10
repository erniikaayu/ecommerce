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
        Schema::create('transaksi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pelanggan_id')->constrained('pelanggan');
            $table->decimal('total_harga', 10, 2);
            $table->foreignId('produk_id')->constrained('produk');
            $table->text('deskripsi')->nullable();  // Allow NULL values for deskripsi
            $table->string('nomor_invoice');
            $table->enum('status_pembayaran', ['pending', 'succes', 'cancelled']);
            $table->timestamp('tanggal_pembelian');
            $table->timestamp('tanggal_pembayaran')->nullable();
            $table->timestamps();

            // Menambahkan indexing pada kolom yang sering dicari
            $table->index('pelanggan_id');  // Index pada pelanggan_id
            $table->index('produk_id');     // Index pada produk_id
            $table->index('status_pembayaran');  // Index pada status_pembayaran
            $table->index('tanggal_pembelian');  // Index pada tanggal_pembelian
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
