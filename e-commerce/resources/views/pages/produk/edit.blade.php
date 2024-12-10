<!-- resources/views/pages/produk/edit.blade.php -->
@extends('layouts.app')

@section('content')
    <h1>Edit Produk</h1>

    <form action="{{ route('produk.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="form-group">
            <label for="nama">Nama Produk</label>
            <input type="text" class="form-control" id="nama" name="nama" value="{{ old('nama', $produk->nama) }}" required>
            @error('nama') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="kategori_id">Kategori Produk</label>
            <select class="form-control" id="kategori_id" name="kategori_id" required>
                <option value="">Pilih Kategori</option>
                @foreach ($kategoris as $kategori)
                    <option value="{{ $kategori->id }}" {{ old('kategori_id', $produk->kategori_id) == $kategori->id ? 'selected' : '' }}>
                        {{ $kategori->nama }}
                    </option>
                @endforeach
            </select>
            @error('kategori_id') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="harga">Harga Produk</label>
            <input type="number" class="form-control" id="harga" name="harga" value="{{ old('harga', $produk->harga) }}" required>
            @error('harga') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
    <label for="berat">Berat Produk (gram)</label>
    <input type="number" step="1" class="form-control" id="berat" name="berat" value="{{ old('berat') }}" required>
    @error('berat') <span class="text-danger">{{ $message }}</span> @enderror
</div>


        <div class="form-group">
            <label for="foto_produk">Foto Produk</label>
            <input type="file" class="form-control-file" id="foto_produk" name="foto_produk">
            @error('foto_produk') <span class="text-danger">{{ $message }}</span> @enderror
            @if($produk->foto_produk)
                <img src="{{ asset('foto_produk/' . $produk->foto_produk) }}" alt="Foto Produk" width="100">
            @endif
        </div>

        <div class="form-group">
            <label for="deskripsi">Deskripsi Produk</label>
            <textarea class="form-control" id="deskripsi" name="deskripsi">{{ old('deskripsi', $produk->deskripsi) }}</textarea>
            @error('deskripsi') <span class="text-danger">{{ $message }}</span> @enderror
        </div>

        <button type="submit" class="btn btn-warning">Perbarui Produk</button>
    </form>
@endsection
