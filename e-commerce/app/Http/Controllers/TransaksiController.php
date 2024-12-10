<?php

namespace App\Http\Controllers;

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
        $transaksis = Transaksi::with(['pelanggan', 'produk'])->get();
        return view('pages.transaksi.transaksi', compact('transaksis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pelanggans = Pelanggan::all();
        $produks = Produk::all();
        return view('pages.transaksi.tambah', compact('pelanggans', 'produks'));
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

        Transaksi::create($validated);
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
    return view('pages.transaksi.transaksi');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaksi $transaksi)
    {
        $pelanggans = Pelanggan::all();
        $produks = Produk::all();
        return view('pages.transaksi.edit', compact('transaksi', 'pelanggans', 'produks'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Transaksi $transaksi)
    {
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
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaksi $transaksi)
    {
        $transaksi->delete();
        return redirect()->route('transaksi.index')->with('success', 'Transaksi berhasil dihapus');
    }
}
