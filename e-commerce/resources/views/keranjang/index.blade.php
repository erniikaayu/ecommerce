@extends('layouts.customer')

@section('content')
<div class="container">
    <h1>Keranjang Belanja</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    @if ($cartItems->isEmpty())
        <p>Keranjang Anda kosong.</p>
        <a href="{{ route('produk.indexPelanggan') }}" class="btn btn-primary">Lihat Produk</a>
    @else
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Foto Produk</th>
                    <th>Nama Produk</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                    <th>Berat Satuan</th>
                    <th>Total Berat</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($cartItems as $item)
                    <tr>
                        <td>
                            @if ($item->produk->foto_produk)
                                <img src="{{ asset('foto_produk/' . $item->produk->foto_produk) }}" alt="{{ $item->produk->nama }}" width="100">
                            @else
                                <span>Tanpa Gambar</span>
                            @endif
                        </td>
                        <td>{{ $item->produk->nama }}</td>
                        <td>Rp{{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                        <td>{{ $item->quantity }}</td>
                        <td>{{ $item->produk->berat }} gram</td>
                        <td>{{ $item->total_berat }} gram</td>
                        <td>Rp{{ number_format($item->produk->harga * $item->quantity, 0, ',', '.') }}</td>
                        <td>
                            <form action="{{ route('keranjang.remove', $item->produk_id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-3">
            <h4>Total Berat: {{ $totalWeight }} gram</h4>
            <a href="{{ route('checkout.index') }}" class="btn btn-success">Checkout</a>
        </div>
    @endif
</div>
@endsection
