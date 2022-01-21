@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{-- {{ __('You are logged in!') }} --}}
                    <a href="{{ route('order.create') }}"> Order </a>
                </div>
            </div>

            <div class="card mt-3">
                <div class="card-header">Grafik</div>

                <canvas id="myChart" width="600" height="400"></canvas>
            </div>

            <div class="card mt-3">
                <div class="card-header">Riwayat Terakhir Pesanan</div>

                <div class="card-body">
                    @if (!$order)
                        <div class="form-group row">
                            <label for="name" class="col-md-12 col-form-label text-md-center">----- Tidak ada -----</label>
                        </div>
                    @else
                        <div class="form-group row">
                            <label for="name" class="col-md-3 col-form-label text-md-left"> Nama Pemesan </label>

                            <div class="col-md-7 col-form-label">
                                : {{$order->name}}
                            </div>

                            <label for="name" class="col-md-3 col-form-label text-md-left"> Nomor Identitas </label>

                            <div class="col-md-7 col-form-label">
                                : {{$order->identity}}
                            </div>

                            <label for="name" class="col-md-3 col-form-label text-md-left"> Jenis Kelamin </label>

                            <div class="col-md-7 col-form-label">
                                : {{$order->gender == 'male' ? 'Laki - laki' : 'Perempuan'}}
                            </div>

                            <label for="name" class="col-md-3 col-form-label text-md-left"> Tipe Kamar </label>

                            <div class="col-md-7 col-form-label">
                                : {{ ucfirst($order->typeroom) }}
                            </div>

                            <label for="name" class="col-md-3 col-form-label text-md-left"> Durasi Penginapan </label>

                            <div class="col-md-7 col-form-label">
                                : {{ $order->duration }} Hari
                            </div>

                            <label for="name" class="col-md-3 col-form-label text-md-left"> Discount </label>

                            <div class="col-md-7 col-form-label">
                                : {{ $order->disc}}%
                            </div>

                            <label for="name" class="col-md-3 col-form-label text-md-left"> Total Bayar </label>

                            <div class="col-md-7 col-form-label">
                                : {{$order->totalprice}}
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    const ctx = document.getElementById('myChart');
    const myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($label) !!},
            datasets: [{
                label: 'Pemesan',
                data: {!! json_encode($data) !!},
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>
@endpush
