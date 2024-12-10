<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Http\Request;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pelanggans = Pelanggan::all();
        return view('pages.pelanggan.pelanggan', compact('pelanggans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.pelanggan.tambah');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'email' => 'required|email|unique:pelanggan,email',
            'nomor_hp' => 'required|unique:pelanggan,nomor_hp',
            'alamat' => 'required',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('foto_profil')) {
            $file = $request->file('foto_profil');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('foto_profil'), $filename);
            $validated['foto_profil'] = $filename; // Menyimpan nama file
        } else {
            $validated['foto_profil'] = null; // Atau default image jika diperlukan
        }
    
        // Menyimpan data produk ke database
        Pelanggan::create($validated);
    
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil ditambahkan');
    }
    
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pelanggan $pelanggan)
    {
        return view('pages.pelanggan.edit', compact('pelanggan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pelanggan $pelanggan)
    {
        $validated = $request->validate([
            'nama_lengkap' => 'required|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'email' => 'required|email|unique:pelanggan,email,'.$pelanggan->id,
            'nomor_hp' => 'required|unique:pelanggan,nomor_hp,'.$pelanggan->id,
            'alamat' => 'required',
            'foto_profil' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        if ($request->hasFile('foto_profil')) {
            $path = $request->file('foto_profil')->store('public/foto_profil');
            $validated['foto_profil'] = str_replace('public/', '', $path);
        }

        $pelanggan->update($validated);
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelanggan $pelanggan)
    {
        $pelanggan->delete();
        return redirect()->route('pelanggan.index')->with('success', 'Pelanggan berhasil dihapus');
    }
}
