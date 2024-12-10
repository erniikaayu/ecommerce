@extends('layouts.customer')

@section('title', 'Selamat Datang di E\'STORE')

@section('hero')
<div class="hero-section">
    <div class="container text-center">
        <h1>Selamat Datang di E'STORE</h1>
        <p>Temukan produk berkualitas dengan harga terjangkau</p>
        <a href="{{ route('produk.indexPelanggan') }}" class="btn btn-warning text-dark mt-3 px-4 py-2">Belanja Sekarang</a>
    </div>
</div>
@endsection

@section('content')
<div class="row">
    <div class="col-12 mb-4">
        <h2 class="text-center mb-4">Produk Unggulan</h2>
    </div>

    @forelse($produkTerbaru as $produk)
    <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
            <img src="{{ asset('foto_produk/' . $produk->foto_produk) }}" class="card-img-top" alt="Gambar produk {{ $produk->nama }}">
            <div class="card-body d-flex flex-column">
                <h5 class="card-title">{{ $produk->nama }}</h5>
                <p class="card-text text-muted">{{ Str::limit($produk->deskripsi, 100) }}</p>
                <div class="mt-auto">
                    <p class="produk-price">Harga: Rp {{ number_format($produk->harga, 0, ',', '.') }}</p>
                    <a href="{{ route('produk.showPelanggan', $produk->id) }}" class="btn btn-info mt-2">Lihat Detail</a>
                    <!-- Add to cart button -->
                    <a href="{{ route('produk.keranjang', $produk->id) }}" class="btn btn-success add-to-cart mt-2">Tambah ke Keranjang</a>
                    <!-- Buy button -->
                    <a href="{{ route('produk.keranjang', $produk->id) }}" class="btn btn-danger mt-2">Beli Sekarang</a>
                </div>
            </div>
        </div>
    </div>
    @empty
    <div class="col-12">
        <div class="alert alert-info text-center" role="alert">
            Belum ada produk tersedia saat ini.
        </div>
    </div>
    @endforelse
</div>


<div class="row mt-5">
    <div class="col-12">
        <div class="card bg-light">
            <div class="card-body text-center">
                <h3>Mengapa Memilih E'STORE?</h3>
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="mb-3">
                            <i class="fas fa-shipping-fast text-primary fs-2"></i>
                            <h5 class="mt-2">Pengiriman Cepat</h5>
                            <p class="text-muted">Produk sampai dalam waktu 1-3 hari kerja</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <i class="fas fa-shield-alt text-primary fs-2"></i>
                            <h5 class="mt-2">Kualitas Terjamin</h5>
                            <p class="text-muted">Produk berkualitas tinggi dan original</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="mb-3">
                            <i class="fas fa-headset text-primary fs-2"></i>
                            <h5 class="mt-2">Layanan Pelanggan</h5>
                            <p class="text-muted">Siap membantu Anda 24/7</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endpush