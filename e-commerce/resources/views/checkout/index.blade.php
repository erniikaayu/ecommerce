@extends('layouts.customer')

@section('content')
<div class="container">
    <h2>Checkout</h2>

    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @elseif (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    @if ($cartItems->isEmpty())
        <p>Keranjang Anda kosong.</p>
    @else
        <div class="table-responsive">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Foto</th>
                        <th>Nama Produk</th>
                        <th>Harga</th>
                        <th>Jumlah</th>
                        <th>Total Berat (gram)</th>
                        <th>Subtotal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cartItems as $item)
                        <tr>
                            <td>
                                <img src="{{ asset('foto_produk/' . $item->produk->foto_produk) }}" alt="{{ $item->produk->nama }}" style="width: 80px; height: 80px;">
                            </td>
                            <td>{{ $item->produk->nama }}</td>
                            <td>Rp {{ number_format($item->produk->harga, 0, ',', '.') }}</td>
                            <td>{{ $item->quantity }}</td>
                            <td>{{ $item->produk->berat * $item->quantity }} gram</td>
                            <td>Rp {{ number_format($item->produk->harga * $item->quantity, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('checkout.remove', $item->produk_id) }}" class="btn btn-danger btn-sm">Hapus</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <form action="{{ route('checkout') }}" method="POST">
            @csrf
            <div class="row">
                <!-- Informasi Pelanggan -->
                <div class="col-md-6">
                    <h4>Informasi Pelanggan</h4>
                    <div class="form-group">
                        <label for="customer_name">Nama Lengkap</label>
                        <input type="text" name="customer_name" id="customer_name" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="customer_email">Email</label>
                        <input type="email" name="customer_email" id="customer_email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="customer_phone">Nomor Telepon</label>
                        <input type="text" name="customer_phone" id="customer_phone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="customer_address">Alamat Lengkap</label>
                        <textarea name="customer_address" id="customer_address" rows="3" class="form-control" required></textarea>
                    </div>
                </div>

                <!-- Informasi Pengiriman -->
                <div class="col-md-6">
                    <h4>Informasi Pengiriman</h4>
                    <div class="form-group">
                        <label for="province">Pilih Provinsi</label>
                        <select name="province" id="province" class="form-control">
                            @foreach ($provinces as $province)
                                <option value="{{ $province['province_id'] }}">{{ $province['province'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="destination">Pilih Kota</label>
                        <select name="destination" id="destination" class="form-control">
                            <!-- Cities will be loaded here based on the province selection -->
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="courier">Pilih Kurir</label>
                        <select name="courier" id="courier" class="form-control">
                            <option value="jne">JNE</option>
                            <option value="pos">POS Indonesia</option>
                            <option value="tiki">TIKI</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="weight">Total Berat (gram)</label>
                        <input type="text" name="weight" id="weight" value="{{ $totalWeight }}" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="shipping_service">Pilih Layanan Pengiriman</label>
                        <select name="shipping_service" id="shipping_service" class="form-control">
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="total_cost">Total Harga (Produk + Ongkir)</label>
                        <input type="text" name="total_cost" id="total_cost" class="form-control" value="{{ $totalCost ?? 0 }}" readonly>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-success mt-3">Bayar</button>
            <a href="{{ route('keranjang.index') }}" class="btn btn-secondary mt-3">Kembali ke Keranjang</a>
        </form>
    @endif
</div>
@endsection
@push('scripts')
<script>
    // Fetch cities when a province is selected
    document.getElementById('province').addEventListener('change', function() {
        var provinceId = this.value;
        fetchCities(provinceId);
        fetchShippingServices(provinceId); 
    });

    function fetchCities(provinceId) {
        fetch("{{ route('checkout.getCities') }}?province_id=" + provinceId)
            .then(response => response.json())
            .then(data => {
                var destinationSelect = document.getElementById('destination');
                destinationSelect.innerHTML = '';

                data.forEach(function(city) {
                    var option = document.createElement('option');
                    option.value = city.city_id;
                    option.textContent = city.city_name;
                    destinationSelect.appendChild(option);
                });
            });
    }

    function fetchShippingServices(provinceId) {
    var destinationId = document.getElementById('destination').value;
    var weight = document.getElementById('weight').value;
    var courier = document.getElementById('courier').value;

    fetch("{{ route('checkout.getShippingServices') }}?destination=" + destinationId + "&weight=" + weight + "&courier=" + courier)
        .then(response => response.json())
        .then(data => {
            console.log(data);  // Debug to inspect the response

            var shippingServiceSelect = document.getElementById('shipping_service');
            shippingServiceSelect.innerHTML = '<option value="">Pilih Layanan Pengiriman</option>'; // Reset options

            if (data && data.length) {
                data.forEach(function(service) {
                    var option = document.createElement('option');
                    option.value = service.service;
                    option.textContent = `${service.service.toUpperCase()} - Rp ${service.cost[0].value.toLocaleString()} (Estimasi: ${service.cost[0].etd} hari)`;
                    shippingServiceSelect.appendChild(option);
                });
            } else {
                shippingServiceSelect.innerHTML = '<option value="">No shipping services available</option>';
            }
        })
        .catch(error => {
            console.error('Error fetching shipping services:', error);
        });
}


    // Calculate the total cost (products + shipping) when a service is selected
    document.getElementById('shipping_service').addEventListener('change', function() {
        var selectedService = this.selectedOptions[0];
        var shippingCost = selectedService ? parseInt(selectedService.text.split(' - Rp ')[1].split(' ')[0].replace(',', '')) : 0;
        var totalProductCost = @json($cartItems->sum(function ($item) {
            return $item->produk->harga * $item->quantity;
        }));

        var totalCost = totalProductCost + shippingCost;
        document.getElementById('total_cost').value = totalCost.toLocaleString('id-ID');
    });
</script>
@endpush
