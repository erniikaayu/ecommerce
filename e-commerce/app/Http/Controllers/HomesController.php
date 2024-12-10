<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class HomesController extends Controller
{
    /**
     * Menampilkan halaman utama dengan produk terbaru
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Ambil 6 produk terbaru berdasarkan waktu pembuatan
        $produkTerbaru = Produk::latest()->take(6)->get();

        // Kirim data produk ke view
        return view('pages.homes', [
            'produkTerbaru' => $produkTerbaru,
        ]);
    }
}
