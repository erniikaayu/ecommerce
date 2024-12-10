@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Daftar Transaksi</h1>

    <table class="table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Pelanggan</th>
                <th>Total Harga</th>
                <th>Produk</th>
                <th>Deskripsi</th>
                <th>Nomor Invoice</th>
                <th>Status Pembayaran</th>
                <th>Tanggal Pembelian</th>
                <th>Tanggal Pembayaran</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksis as $transaksi)
            <tr>
                <td>{{ $transaksi->id }}</td>
                <td>{{ $transaksi->pelanggan->nama_lengkap }}</td>
                <td>Rp {{ number_format($transaksi->total_harga, 2) }}</td>
                <td>{{ $transaksi->produk->nama }}</td>
                <td>{{ Str::limit($transaksi->deskripsi, 50) }}</td>
                <td>{{ $transaksi->nomor_invoice }}</td>
                <td>
                    @if($transaksi->status_pembayaran == 'pending')
                        <span class="badge bg-warning">Pending</span>
                    @elseif($transaksi->status_pembayaran == 'paid')
                        <span class="badge bg-success">Paid</span>
                    @else
                        <span class="badge bg-danger">Cancelled</span>
                    @endif
                </td>
                <td>{{ $transaksi->tanggal_pembelian }}</td>
                <td>{{ $transaksi->tanggal_pembayaran ?? '-' }}</td>
                <td>
                    <a href="{{ route('transaksi.show', $transaksi->id) }}" class="btn btn-sm btn-info">Detail</a>
                    <a href="{{ route('transaksi.edit', $transaksi->id) }}" class="btn btn-sm btn-primary">Edit</a>
                    <form action="{{ route('transaksi.destroy', $transaksi->id) }}" method="POST" style="display: inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">Hapus</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <a href="{{ route('transaksi.create') }}" class="btn btn-success">Tambah Transaksi Baru</a>
</div>
@endsection