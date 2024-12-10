<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $kategoris = Kategori::paginate(10); // Menggunakan pagination
        return response()->json($kategoris);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|max:255',
            'keterangan' => 'required',
        ]);

        $kategori = Kategori::create($validated);
        return response()->json($kategori, 201); // Mengembalikan data baru dengan status 201 Created
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $kategori = Kategori::find($id);
        if (!$kategori) {
            return response()->json(['message' => 'Kategori not found'], 404);
        }
        return response()->json($kategori);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $kategori = Kategori::find($id);
        if (!$kategori) {
            return response()->json(['message' => 'Kategori not found'], 404);
        }

        $validated = $request->validate([
            'nama' => 'required|max:255',
            'keterangan' => 'required',
        ]);

        $kategori->update($validated);
        return response()->json($kategori);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $kategori = Kategori::find($id);
        if (!$kategori) {
            return response()->json(['message' => 'Kategori not found'], 404);
        }

        $kategori->delete();
        return response()->json(['message' => 'Kategori deleted successfully']);
    }

    public function getKategoriWithTotalProduk()
    {   
    $kategori = Kategori::withCount('produk')->get();
    return response()->json($kategori);
    }

}
