<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaksi extends Model
{
    use HasFactory;

    protected $table = 'transaksi';

    protected $fillable = [
        'pelanggan_id',
        'total_harga',
        'produk_id',
        'deskripsi',
        'nomor_invoice',
        'status_pembayaran',
        'tanggal_pembelian',
        'tanggal_pembayaran'
    ];

    public function pelanggan()
    {
    return $this->belongsTo(Pelanggan::class);
    }

    public function produk()
    {
    return $this->belongsTo(Produk::class);
    }
}