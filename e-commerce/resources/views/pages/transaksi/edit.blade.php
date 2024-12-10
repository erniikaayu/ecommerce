@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Edit Transaksi</h1>

    <form action="{{ route('transaksi.update', $transaksi->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="pelanggan_id">Pelanggan</label>
            <select name="pelanggan_id" id="pelanggan_id" class="form-control" required>
                <option value="">Pilih Pelanggan</option>
                @foreach($pelanggans as $pelanggan)
                    <option value="{{ $pelanggan->id }}" {{ $transaksi->pelanggan_id == $pelanggan->id ? 'selected' : '' }}>
                        {{ $pelanggan->nama_lengkap }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="produk_id">Produk</label>
            <select name="produk_id" id="produk_id" class="form-control" required>
                <option value="">Pilih Produk</option>
                @foreach($produks as $produk)
                    <option value="{{ $produk->id }}" {{ $transaksi->produk_id == $produk->id ? 'selected' : '' }}>
                        {{ $produk->nama }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="form-group">
            <label for="total_harga">Total Harga</label>
            <input type="number" name="total_harga" id="total_harga" class="form-control" step="0.01" value="{{ $transaksi->total_harga }}" required>
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi</label>
            <textarea name="deskripsi" id="deskripsi" class="form-control" rows="3" required>{{ $transaksi->deskripsi }}</textarea>
        </div>

        <div class="form-group">
            <label for="nomor_invoice">Nomor Invoice</label>
            <input type="text" name="nomor_invoice" id="nomor_invoice" class="form-control" value="{{ $transaksi->nomor_invoice }}" required>
        </div>

        <div class="form-group">
            <label for="status_pembayaran">Status Pembayaran</label>
            <select name="status_pembayaran" id="status_pembayaran" class="form-control" required>
                <option value="pending" {{ $transaksi->status_pembayaran == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="paid" {{ $transaksi->status_pembayaran == 'paid' ? 'selected' : '' }}>Paid</option>
                <option value="cancelled" {{ $transaksi->status_pembayaran == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
            </select>
        </div>

        <div class="form-group">
            <label for="tanggal_pembelian">Tanggal Pembelian</label>
            <input type="datetime-local" name="tanggal_pembelian" id="tanggal_pembelian" class="form-control" value="{{ date('Y-m-d\TH:i', strtotime($transaksi->tanggal_pembelian)) }}" required>
        </div>

        <div class="form-group">
            <label for="tanggal_pembayaran">Tanggal Pembayaran</label>
            <input type="datetime-local" name="tanggal_pembayaran" id="tanggal_pembayaran" class="form-control" value="{{ $transaksi->tanggal_pembayaran ? date('Y-m-d\TH:i', strtotime($transaksi->tanggal_pembayaran)) : '' }}">
        </div>

        <button type="submit" class="btn btn-primary">Update Transaksi</button>
    </form>
</div>
@endsection