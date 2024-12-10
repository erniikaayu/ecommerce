@extends('layouts.app')

@section('content')
<div class="container">
    <h1 class="mb-4">Daftar Pelanggan</h1>
    
    <a href="{{ route('pelanggan.create') }}" class="btn btn-primary mb-3">Tambah Pelanggan Baru</a>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Lengkap</th>
                <th>Jenis Kelamin</th>
                <th>Email</th>
                <th>Nomor HP</th>
                <th>Alamat</th>
                <th>Foto Profil</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pelanggans as $pelanggan)
            <tr>
                <td>{{ $pelanggan->id }}</td>
                <td>{{ $pelanggan->nama_lengkap }}</td>
                <td>{{ $pelanggan->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                <td>{{ $pelanggan->email }}</td>
                <td>{{ $pelanggan->nomor_hp }}</td>
                <td>{{ $pelanggan->alamat }}</td>
                <td>
                    @if ($pelanggan->foto_profil)
                        <img src="{{ asset('foto_profil/' . $pelanggan->foto_profil) }}" alt="{{ $pelanggan->nama_lengkap }}" style="width: 100px; height: auto;">
                    @else
                        <img src="{{ asset('path/to/default/image.jpg') }}" alt="Default Image" style="width: 100px; height: auto;">
                    @endif
                </td>
                <td>
                    <a href="{{ route('pelanggan.edit', $pelanggan->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('pelanggan.destroy', $pelanggan->id) }}" method="POST" class="d-inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus pelanggan ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
