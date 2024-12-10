@extends('layouts.customer')
@section('title', 'Detail Produk')
@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <div class="card border-0 shadow-lg">
                <div class="row g-0">
                    <!-- Kolom Gambar Produk -->
                    <div class="col-md-6 p-4">
                        <div class="position-relative h-100">
                            <img src="{{ asset('foto_produk/' . ($produk->foto_produk ?? 'default.jpg')) }}" 
                                 class="img-fluid rounded-3 w-100 h-100 object-fit-cover" 
                                 alt="{{ $produk->nama }}"
                                 style="max-height: 500px;">
                            <span class="position-absolute top-0 start-0 mt-3 ms-3 badge bg-primary">
                                {{ $produk->kategori->nama }}
                            </span>
                        </div>
                    </div>
                    
                    <!-- Kolom Detail Produk -->
                    <div class="col-md-6 p-4 d-flex flex-column">
                        <div class="flex-grow-1">
                            <h2 class="card-title text-center text-dark mb-4 fw-bold">{{ $produk->nama }}</h2>
                            
                            <div class="mb-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span class="h4 text-primary mb-0">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                                    <small class="text-muted">Berat: {{ $produk->berat }} gram</small>
                                </div>
                            </div>

                            <hr class="my-3">

                            <div class="mb-4">
                                <h5 class="text-dark">Deskripsi Produk</h5>
                                <p class="text-muted">
                                    {{ $produk->deskripsi ?? 'Tidak ada deskripsi tersedia untuk produk ini.' }}
                                </p>
                            </div>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="mt-auto">
                            <div class="d-grid gap-2">
                                <a href="{{ route('produk.keranjang', $produk->id) }}" 
                                   class="btn btn-primary btn-lg rounded-pill">
                                    <i class="fas fa-shopping-cart me-2"></i>Tambah ke Keranjang
                                </a>
                                <a href="{{ route('produk.indexPelanggan') }}" 
                                   class="btn btn-outline-secondary btn-lg rounded-pill">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali ke Daftar Produk
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection