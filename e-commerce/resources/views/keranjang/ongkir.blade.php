{{-- resources/views/keranjang/ongkir.blade.php --}}

@extends('layouts.customer')

@section('content')
<div class="container my-5">
    <h2>Hasil Pengecekan Ongkos Kirim</h2>

    @if(!empty($results))
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Kurir</th>
                    <th>Servis</th>
                    <th>Estimasi Waktu</th>
                    <th>Biaya</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($results as $cost)
                    <tr>
                        <td>{{ strtoupper($cost['service']) }}</td>
                        <td>{{ $cost['description'] }}</td>
                        <td>{{ $cost['etd'] }} hari</td>
                        <td>Rp. {{ number_format($cost['cost'][0]['value'], 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @else
        <p class="text-muted">Tidak ada hasil ongkos kirim yang ditemukan.</p>
    @endif
</div>
@endsection
