<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaksi;
use App\Models\Pelanggan;
use App\Models\Produk;
use Illuminate\Http\Request;

class TransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $transaksis = Transaksi::with(['pelanggan', 'produk'])->paginate(10); // Menggunakan pagination
        return response()->json($transaksis);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'produk_id' => 'required|exists:produk,id',
            'total_harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable',
            'nomor_invoice' => 'required|unique:transaksi,nomor_invoice',
            'status_pembayaran' => 'required|in:pending,paid,cancelled',
            'tanggal_pembelian' => 'required|date',
            'tanggal_pembayaran' => 'nullable|date'
        ]);

        $transaksi = Transaksi::create($validated);
        return response()->json($transaksi, 201); // Mengembalikan data baru dengan status 201 Created
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transaksi = Transaksi::with(['pelanggan', 'produk'])->find($id);
        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi not found'], 404);
        }
        return response()->json($transaksi);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $transaksi = Transaksi::find($id);
        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi not found'], 404);
        }

        $validated = $request->validate([
            'pelanggan_id' => 'required|exists:pelanggan,id',
            'produk_id' => 'required|exists:produk,id',
            'total_harga' => 'required|numeric|min:0',
            'deskripsi' => 'nullable',
            'nomor_invoice' => 'required|unique:transaksi,nomor_invoice,'.$transaksi->id,
            'status_pembayaran' => 'required|in:pending,paid,cancelled',
            'tanggal_pembelian' => 'required|date',
            'tanggal_pembayaran' => 'nullable|date'
        ]);

        $transaksi->update($validated);
        return response()->json($transaksi);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $transaksi = Transaksi::find($id);
        if (!$transaksi) {
            return response()->json(['message' => 'Transaksi not found'], 404);
        }

        $transaksi->delete();
        return response()->json(['message' => 'Transaksi deleted successfully']);
    }
}
