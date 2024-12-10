<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Keranjang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource for admins.
     */
    public function index()
    {
        // Implementasi caching untuk daftar produk (admin view)
        $produks = Cache::remember('produks', 60, function () {
            return Produk::with('kategori')->get();
        });

        return view('pages.produk.produk', compact('produks'));
    }

    /**
     * Display a listing of the resource for customers.
     */
    public function indexPelanggan(Request $request)
    {
        // Menampilkan produk dengan filter kategori (jika ada)
        $produks = Produk::with('kategori')
                        ->when($request->kategori_id, function ($query) use ($request) {
                            return $query->where('kategori_id', $request->kategori_id);
                        })
                        ->get();

        // Mengambil semua kategori untuk filter
        $kategoris = Kategori::all();
        

        return view('produk.index', compact('produks', 'kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Implementasi caching untuk daftar kategori
        $kategoris = Cache::remember('kategoris', 60, function () {
            return Kategori::all();
        });

        return view('pages.produk.tambah', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'harga' => 'required|numeric',
            'foto_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'berat' => 'required|numeric|min:1', // Ensure weight is in grams and positive
            'deskripsi' => 'nullable|string',
        ]);

        if ($request->hasFile('foto_produk')) {
            $file = $request->file('foto_produk');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('foto_produk'), $filename);
            $validated['foto_produk'] = $filename;
        } else {
            $validated['foto_produk'] = null;
        }

        Produk::create($validated);

        Cache::forget('produks');

        return redirect()->route('produk.index')->with('success', 'Produk berhasil ditambahkan');
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Produk $produk)
    {
        $kategoris = Cache::remember('kategoris', 60, function () {
            return Kategori::all();
        });

        return view('pages.produk.edit', compact('produk', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Produk $produk)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'harga' => 'required|numeric',
            'foto_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'berat' => 'required|numeric|min:1', // Ensure weight is in grams and positive
            'deskripsi' => 'nullable|string',
        ]);

        if ($request->hasFile('foto_produk')) {
            $file = $request->file('foto_produk');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('foto_produk'), $filename);
            $validated['foto_produk'] = $filename;
        }

        $produk->update($validated);

        Cache::forget('produks');

        return redirect()->route('produk.index')->with('success', 'Produk berhasil diperbarui');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Produk $produk)
    {
        $produk->delete();

        Cache::forget('produks');
        Cache::forget('produks_customer');

        return redirect()->route('produk.index')->with('success', 'Produk berhasil dihapus');
    }

    /**
     * Add a product to the shopping cart.
     */
    public function keranjang(Request $request, $id)
    {
        $produk = Produk::findOrFail($id);

        // Periksa apakah produk sudah ada di keranjang untuk pengguna saat ini
        $keranjang = Keranjang::where('user_id', auth()->id())
                              ->where('produk_id', $id)
                              ->first();

        if ($keranjang) {
            // Jika produk sudah ada, tambahkan jumlahnya
            $keranjang->increment('quantity');
        } else {
            // Jika belum ada, tambahkan produk ke keranjang
            Keranjang::create([
                'user_id' => auth()->id(),
                'produk_id' => $id,
                'quantity' => 1,
            ]);
        }

        return redirect()->route('keranjang.index')->with('success', 'Produk berhasil ditambahkan ke keranjang');
    }

    /**
     * Proceed to the checkout (purchase).
     */
    public function checkout()
    {
        $cart = session()->get('keranjang', []);

        if (empty($cart)) {
            return redirect()->route('produk.indexPelanggan')->with('error', 'Keranjang Anda kosong');
        }

        // Di sini Anda dapat menambahkan logika tambahan seperti menyimpan transaksi ke database.

        session()->forget('keranjang');

        return redirect()->route('produk.indexPelanggan')->with('success', 'Checkout berhasil');
    }

    public function showPelanggan($id)
    {
        // Get the product details along with the category
        $produk = Produk::with('kategori')->findOrFail($id);

        return view('produk.detail', compact('produk'));
    }
}
