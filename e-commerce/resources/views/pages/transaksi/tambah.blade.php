@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    Tambah Transaksi
                </div>
                <div class="card-body">
                    <form method="POST" action="{{ route('transaksi.store') }}">
                        @csrf

                        <!-- Dropdown Pelanggan -->
                        <div class="mb-3">
                            <label for="pelanggan_id" class="form-label">Pilih Pelanggan</label>
                        <select class="form-select" name="pelanggan_id" required>
                            <option value="">-- Pilih Pelanggan --</option>
                            @foreach($pelanggans as $pelanggan)
                            <option value="{{ $pelanggan->id }}">{{ $pelanggan->nama_lengkap }}</option>
                            @endforeach
                        </select>
                            @error('pelanggan_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Dropdown Produk -->
                        <div class="mb-3">
                            <label for="produk_id" class="form-label">Pilih Produk</label>
                            <select class="form-select @error('produk_id') is-invalid @enderror" 
                                    name="produk_id" id="produk_id" required>
                                <option value="">-- Pilih Produk --</option>
                                @foreach($produks as $produk)
                                    <option value="{{ $produk->id }}">{{ $produk->nama }}</option>
                                @endforeach
                            </select>
                            @error('produk_id')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Total Harga -->
                        <div class="mb-3">
                            <label for="total_harga" class="form-label">Total Harga</label>
                            <input type="number" class="form-control @error('total_harga') is-invalid @enderror" 
                                   name="total_harga" id="total_harga" value="{{ old('total_harga') }}" required>
                            @error('total_harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Nomor Invoice -->
                        <div class="mb-3">
                            <label for="nomor_invoice" class="form-label">Nomor Invoice</label>
                            <input type="text" class="form-control @error('nomor_invoice') is-invalid @enderror" 
                                   name="nomor_invoice" id="nomor_invoice" value="{{ old('nomor_invoice') }}" required>
                            @error('nomor_invoice')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Tanggal Pembelian -->
                        <div class="mb-3">
                            <label for="tanggal_pembelian" class="form-label">Tanggal Pembelian</label>
                            <input type="date" class="form-control @error('tanggal_pembelian') is-invalid @enderror" 
                                   name="tanggal_pembelian" id="tanggal_pembelian" value="{{ old('tanggal_pembelian') }}" required>
                            @error('tanggal_pembelian')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Tanggal Pembayaran (Optional) -->
                        <div class="mb-3">
                            <label for="tanggal_pembayaran" class="form-label">Tanggal Pembayaran (Opsional)</label>
                            <input type="date" class="form-control @error('tanggal_pembayaran') is-invalid @enderror" 
                                   name="tanggal_pembayaran" id="tanggal_pembayaran" value="{{ old('tanggal_pembayaran') }}">
                            @error('tanggal_pembayaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Dropdown Status Pembayaran -->
                        <div class="mb-3">
                            <label for="status_pembayaran" class="form-label">Status Pembayaran</label>
                            <select class="form-select @error('status_pembayaran') is-invalid @enderror" 
                                    name="status_pembayaran" id="status_pembayaran" required>
                                <option value="pending" {{ old('status_pembayaran') == 'pending' ? 'selected' : '' }}>Pending</option>
                                <option value="paid" {{ old('status_pembayaran') == 'paid' ? 'selected' : '' }}>Paid</option>
                                <option value="cancelled" {{ old('status_pembayaran') == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                            </select>
                            @error('status_pembayaran')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Input Deskripsi -->
                        <div class="mb-3">
                            <label for="deskripsi" class="form-label">Deskripsi (Opsional)</label>
                            <textarea class="form-control @error('deskripsi') is-invalid @enderror" 
                                      name="deskripsi" id="deskripsi" rows="3">{{ old('deskripsi') }}</textarea>
                            @error('deskripsi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <!-- Tombol Submit -->
                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">Tambah Transaksi</button>
                            <a href="{{ route('transaksi.index') }}" class="btn btn-secondary ms-2">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
