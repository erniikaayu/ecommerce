<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produk extends Model
{
    use HasFactory;

    protected $table = 'produk';

    // Added 'berat' to the fillable array
    protected $fillable = ['nama', 'kategori_id', 'harga', 'foto_produk', 'deskripsi', 'berat'];

    // Optional: Add a method to get weight in grams
    public function getBeratInGramsAttribute()
    {
        return $this->berat . ' gram';
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }
    
    public function transaksi()
    {
        return $this->hasMany(Transaksi::class);
    }
}