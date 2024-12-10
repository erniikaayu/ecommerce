@extends('layouts.customer')

@section('title', 'Daftar Produk')

@section('content')
<div class="container mt-4">
    <h1 class="text-center mb-4">Daftar Produk</h1>
    
    <!-- Filter Kategori -->
    <form method="GET" action="{{ route('produk.indexPelanggan') }}" class="mb-4">
        <div class="row">
            <div class="col-md-4">
                <select name="kategori_id" class="form-select" onchange="this.form.submit()">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" 
                            {{ request('kategori_id') == $kategori->id ? 'selected' : '' }}>
                            {{ $kategori->nama }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Filter</button>
            </div>
        </div>
    </form>

    <!-- Daftar Produk -->
    <div class="row">
        @forelse($produks as $produk)
            <div class="col-md-4 mb-4">
                <div class="card h-100">
                    <img src="{{ asset('foto_produk/' . ($produk->foto_produk ?? 'default.jpg')) }}" 
                         class="card-img-top" alt="{{ $produk->nama }}" style="height: 300px; object-fit: cover;">
                    <div class="card-body">
                        <h5 class="card-title">{{ $produk->nama }}</h5>
                        <p class="card-text">Kategori: {{ $produk->kategori->nama }}</p>
                        <p class="card-text">Harga: Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                        <a href="{{ route('produk.showPelanggan', $produk->id) }}" class="btn btn-primary btn-sm">Lihat Detail</a>
                        <a href="{{ route('produk.keranjang', $produk->id) }}" class="btn btn-success btn-sm">Tambah ke Keranjang</a>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <p class="text-center">Tidak ada produk yang tersedia.</p>
            </div>
        @endforelse
    </div>
</div>
@endsection
