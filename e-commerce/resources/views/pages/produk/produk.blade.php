@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Daftar Produk</h3>
            <div class="card-tools">
                <a href="{{ route('produk.create') }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-plus"></i> Tambah Produk
                </a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Foto</th>
                        <th>Deskripsi</th>
                        <th>Berat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($produks as $produk)
                    <tr>
                        <td>{{ $produk->id }}</td>
                        <td>{{ $produk->nama }}</td>
                        <td>{{ $produk->kategori->nama }}</td>
                        <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                        <td>
                            @if ($produk->foto_produk)
                            <img src="{{ asset('foto_produk/' . $produk->foto_produk) }}" alt="{{ $produk->nama }}" style="width: 100px; height: auto;">
                            @else
                            <img src="{{ asset('path/to/default/image.jpg') }}" alt="Default Image" style="width: 100px; height: auto;">
                            @endif
                        </td>
                        <td>{{ $produk->deskripsi }}</td>
                        <td>{{ $produk->berat }} gram</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('produk.edit', $produk) }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('produk.destroy', $produk) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm" 
                                            onclick="return confirm('Yakin ingin menghapus?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection