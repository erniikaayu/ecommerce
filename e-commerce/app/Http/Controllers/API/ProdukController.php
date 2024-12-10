<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Produk;
use App\Models\Kategori;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $produks = Produk::with('kategori')->paginate(10); // Menggunakan pagination
        return response()->json($produks);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategoris,id', // Perhatikan nama tabel
            'harga' => 'required|numeric',
            'foto_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'nullable|string',
        ]);

        // Menangani upload foto
        if ($request->hasFile('foto_produk')) {
            $file = $request->file('foto_produk');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('foto_produk'), $filename);
            $validated['foto_produk'] = $filename; // Menyimpan nama file
        }

        // Menyimpan data produk ke database
        $produk = Produk::create($validated);

        return response()->json($produk, 201); // Mengembalikan data baru dengan status 201 Created
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $produk = Produk::with('kategori')->find($id);
        if (!$produk) {
            return response()->json(['message' => 'Produk not found'], 404);
        }
        return response()->json($produk);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            return response()->json(['message' => 'Produk not found'], 404);
        }

        $validated = $request->validate([
            'kategori_id' => 'required|exists:kategoris,id',
            'nama' => 'required|max:255',
            'harga' => 'required|numeric|min:0',
            'foto_produk' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'deskripsi' => 'required'
        ]);

        if ($request->hasFile('foto_produk')) {
            // Hapus file foto lama jika ada
            if ($produk->foto_produk) {
                @unlink(public_path('foto_produk/' . $produk->foto_produk));
            }
            $file = $request->file('foto_produk');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('foto_produk'), $filename);
            $validated['foto_produk'] = $filename; // Menyimpan nama file
        }

        $produk->update($validated);
        return response()->json($produk);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produk = Produk::find($id);
        if (!$produk) {
            return response()->json(['message' => 'Produk not found'], 404);
        }

        // Hapus foto jika ada
        if ($produk->foto_produk) {
            @unlink(public_path('foto_produk/' . $produk->foto_produk));
        }

        $produk->delete();
        return response()->json(['message' => 'Produk deleted successfully']);
    }

    public function getProductsWithCategory()
    {
    $products = Produk::with('kategori')
        ->select('id', 'kategori_id', 'nama', 'harga', 'foto_produk', 'deskripsi')
        ->get();

    return response()->json($products);
    }

    public function getProdukWithTotalTransaksi()
    {
    $produk = Produk::withCount('transaksi')
        ->select('id', 'kategori_id', 'nama', 'harga', 'foto_produk', 'deskripsi')
        ->get();

    return response()->json($produk);
    }


}
