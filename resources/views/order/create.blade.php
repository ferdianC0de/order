@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Pemesanan</div>

                <div class="card-body">
                    <form id="orderForm" method="POST" action="{{ route('order.store') }}">
                        @csrf

                        <div class="form-group row">
                            <label for="name" class="col-md-4 col-form-label text-md-right"> Nama </label>

                            <div class="col-md-6">
                                <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

                                @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="gender" class="col-md-4 col-form-label text-md-right"> Jenis Kelamin </label>

                            <div class="form-group col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="gender1" value="male">
                                    <label class="form-check-label" for="gender1">
                                      Laki - laki
                                    </label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="gender" id="gender2" value="female">
                                    <label class="form-check-label" for="gender2">
                                        Perempuan
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="identity" class="col-md-4 col-form-label text-md-right"> Nomor Identitas </label>

                            <div class="col-md-6">
                                <input id="identity" type="text" class="form-control" name="identity" required>
                                <span id="identityFeedback" class="invalid-feedback" role="alert">
                                    <strong>isian salah.. Data harus 16 digit</strong>
                                </span>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="typeroom" class="col-md-4 col-form-label text-md-right"> Tipe Kamar </label>

                            <div class="col-md-6">
                                <select class="form-select" id="typeroom" name="typeroom">
                                    <option selected>Open this select menu</option>
                                    <option value="standar">Standar</option>
                                    <option value="deluxe">Deluxe</option>
                                    <option value="family">Family</option>
                                  </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="price" class="col-md-4 col-form-label text-md-right"> Harga </label>

                            <div class="col-md-6">
                                <input id="price" type="text" class="form-control" name="price" readonly>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label text-md-right"> Tanggal Pesan </label>

                            <div class="col-md-6">
                                <input id="date" type="date" class="form-control datepicker" name="date" id="date" required>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="duration" class="col-md-4 col-form-label text-md-right"> Durasi Menginap </label>

                            <div class="col-md-2">
                                <input id="duration" type="number" class="form-control" name="duration" required>
                                <span id="durationFeedback" class="invalid-feedback" role="alert">
                                    <strong>harus isi angka</strong>
                                </span>
                            </div>
                            <div class="col mt-2">
                                Hari
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="date" class="col-md-4 col-form-label text-md-right"> Termasuk Breakfast </label>

                            <div class="col ml-4 mt-2">
                                <input class="form-control form-check-input" type="checkbox" id="breakfast"> Ya
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="totalprice" class="col-md-4 col-form-label text-md-right"> Total Bayar </label>

                            <div class="col-md-6">
                                <input id="totalprice" type="text" class="form-control" name="totalprice" readonly>
                            </div>
                        </div>
                    </form>
                    <div class="form-group row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button id="submit" class="btn btn-primary">
                                {{ "Order" }}
                            </button>

                            <button class="btn btn-primary" id="mathTotal">
                                {{ "Hitung total bayar" }}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    $(function() {
        const   identity = $('#identity'),
                gender = $('#gender'),
                typeroom = $('#typeroom'),
                price = $('#price'),
                date = $('#date'),
                duration = $('#duration'),
                breakfast = $('#breakfast'),
                totalprice = $('#totalprice'),
                mathtotal = $('#mathTotal');


        identity.change(() => {
            if (identity.val().length < 16) {
                $(identity).addClass('is-invalid')
                $('#identityFeedback').addClass('d-block');
            } else {
                $(identity).removeClass('is-invalid')
                $('#identityFeedback').removeClass('d-block');
            }
        });

        typeroom.change(() => {
            console.log(typeroom.val());
            switch (typeroom.val()) {
                case 'standar':
                price.val('500000')
                    break;
                case 'deluxe':
                price.val('600000')
                    break;
                case 'family':
                price.val('700000')
                    break;
                default :
                price.val('0')
                break
            }
        });

        duration.change(() => {
            var reg = /^\d+$/;
            console.log(reg.test(duration.val()));
            if (!reg.test(duration.val())) {
                $(duration).addClass('is-invalid')
                $('#durationFeedback').addClass('d-block');
            } else {
                $(duration).removeClass('is-invalid')
                $('#durationFeedback').removeClass('d-block');
            }
        });

        mathtotal.click(()=> {
            var total = price.val() * duration.val();
            if (duration.val() > 3) {
                var disc = total * 0.03;
                total = total - disc;
            }

            if (breakfast.prop("checked")) {
                total += 80000;
            }
            totalprice.val(total);
        });


        $('#submit').click(()=>{
            $('#orderForm').submit();
        });
    });
</script>
@endpush
