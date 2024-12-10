<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Menampilkan semua data pelanggan dengan pagination.
     */
    public function index(Request $request)
    {
        $perPage = $request->get('per_page', 10);  // Default 10 data per halaman
        $pelanggan = Pelanggan::paginate($perPage);

        return response()->json($pelanggan, 200);
    }

    /**
     * Menyimpan data pelanggan baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'email' => 'required|email|unique:pelanggan,email',
            'nomor_hp' => 'required|string|max:15',
            'alamat' => 'required|string',
            'foto_profil' => 'nullable|string', // Jika foto profil tidak wajib
        ]);

        $pelanggan = Pelanggan::create($request->all());

        return response()->json([
            'message' => 'Pelanggan berhasil ditambahkan.',
            'data' => $pelanggan
        ], 201);
    }

    /**
     * Menampilkan satu data pelanggan berdasarkan ID.
     */
    public function show($id)
    {
        $pelanggan = Pelanggan::find($id);

        if (!$pelanggan) {
            return response()->json(['message' => 'Pelanggan tidak ditemukan.'], 404);
        }

        return response()->json($pelanggan, 200);
    }

    /**
     * Mengupdate data pelanggan berdasarkan ID.
     */
    public function update(Request $request, $id)
    {
        $pelanggan = Pelanggan::find($id);

        if (!$pelanggan) {
            return response()->json(['message' => 'Pelanggan tidak ditemukan.'], 404);
        }

        $request->validate([
            'nama_lengkap' => 'string|max:255',
            'jenis_kelamin' => 'in:L,P',
            'email' => 'email|unique:pelanggan,email,' . $id,
            'nomor_hp' => 'string|max:15',
            'alamat' => 'string',
            'foto_profil' => 'nullable|string',
        ]);

        $pelanggan->update($request->all());

        return response()->json([
            'message' => 'Pelanggan berhasil diperbarui.',
            'data' => $pelanggan
        ], 200);
    }

    /**
     * Menghapus data pelanggan berdasarkan ID.
     */
    public function destroy($id)
    {
        $pelanggan = Pelanggan::find($id);

        if (!$pelanggan) {
            return response()->json(['message' => 'Pelanggan tidak ditemukan.'], 404);
        }

        $pelanggan->delete();

        return response()->json(['message' => 'Pelanggan berhasil dihapus.'], 200);
    }

    public function getPelangganWithTotalTransaksi()
    {
    return Pelanggan::withCount('transaksi')->get()->map(function ($pelanggan) {
        return [
            'id_pelanggan' => $pelanggan->id,
            'nama_lengkap' => $pelanggan->nama_lengkap,
            'jenis_kelamin' => $pelanggan->jenis_kelamin,
            'email' => $pelanggan->email,
            'nomor_hp' => $pelanggan->nomor_hp,
            'alamat' => $pelanggan->alamat,
            'foto_profil' => $pelanggan->foto_profil,
            'total_transaksi' => $pelanggan->transaksi_count,
        ];
    });
    }

}
