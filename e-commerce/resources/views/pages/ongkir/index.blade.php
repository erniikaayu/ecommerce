@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h2>Cek Ongkos Kirim</h2>
            <div class="card">
                <div class="card-body">
                    <form id="shipping-form" action="{{ route('check.ongkir') }}" method="POST">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Asal (Ngawi, Jawa Timur)</label>
                                    <input type="text" class="form-control" value="Ngawi" disabled>
                                    <input type="hidden" name="origin" value="{{ $originCity }}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Provinsi Tujuan</label>
                                    <select name="province_id" id="province" class="form-control" required>
                                        <option value="">Pilih Provinsi</option>
                                        @foreach($provinces as $province)
                                            <option value="{{ $province['province_id'] }}">
                                                {{ $province['province'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kota Tujuan</label>
                                    <select name="destination" id="city" class="form-control" required>
                                        <option value="">Pilih Kota</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Berat (gram)</label>
                                    <input type="number" name="weight" class="form-control" required>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Kurir</label>
                                    <select name="courier" class="form-control" required>
                                        <option value="jne">JNE</option>
                                        <option value="pos">POS</option>
                                        <option value="tiki">TIKI</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary mt-3">Cek Ongkos Kirim</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    $('#province').on('change', function() {
        var provinceId = $(this).val();
        if(provinceId) {
            $.ajax({
                url: "{{ route('get.cities') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}",
                    province_id: provinceId
                },
                dataType: 'json',
                success: function(data) {
                    $('#city').empty();
                    $('#city').append('<option value="">Pilih Kota</option>');
                    $.each(data, function(key, value) {
                        $('#city').append('<option value="' + value.city_id + '">' + value.city_name + '</option>');
                    });
                }
            });
        }
    });
});
</script>
@endpush
@endsection