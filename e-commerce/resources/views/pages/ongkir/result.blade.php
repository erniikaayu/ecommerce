@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Hasil Pengecekan Ongkos Kirim</h2>
    <table class="table">
        <thead>
            <tr>
                <th>Service</th>
                <th>Deskripsi</th>
                <th>Biaya</th>
                <th>Estimasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($results as $result)
            <tr>
                <td>{{ $result['service'] }}</td>
                <td>{{ $result['description'] }}</td>
                <td>Rp. {{ number_format($result['cost'][0]['value'], 0, ',', '.') }}</td>
                <td>{{ $result['cost'][0]['etd'] }} hari</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <a href="{{ route('ongkir.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection