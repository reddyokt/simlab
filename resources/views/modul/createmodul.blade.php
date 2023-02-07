@extends('dashboard.layouts.main')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

@section('container')
@if (session()-> has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {!! session('success') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error )
        <li> {{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
    <h3 class="h5 my-3 fw-normal text-center">Kebutuhan Modul Praktikum</h3>
    <form action="/modul/createmodul" method="POST" class="col-md d-block align-item-center mx-auto">
        @csrf
        <div class="form-group mb-1">
            <label for="nama_modul">Nama Modul</label>
            <input type="text" name="nama_modul" class="form-control @error('nama_modul') is-invalid @enderror"
            id="nama_modul" placeholder="Nama modul" required value="{{ old ('nama_modul') }}" >
            @error('nama_modul')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-group mb-1">
            <label for="nama_modul">Pilih Kelas</label>
            <select class="form-control" name="praktikum_id" id="kelas_id" required >
                <option selected disabled>Pilih Kelas</option>
            @foreach ( $praktik as $dt )
                <option value="{{ $dt->id_praktikum }}">{{ $dt->nama_kelas }} - {{ $dt->kelas->nama_kelas }}</option>
            @endforeach
            </select>
              @error('kelas_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
             @enderror
        </div>

        <div class="form-group mb-1">
                <label for="nama_modul">Tanggal Praktek</label>
                    <div class="input-group date" id="tanggal_praktek" name="tanggal_praktek"  required>
                        <input id="tanggal_praktek" type="text" class="form-control datepicker" name="tanggal_praktek" value="{{ old ('tanggal_praktek') }}">
                        <span class="input-group-append ">
                            <span class="input-group-text bg-white ">
                                <i class="fa fa-calendar mx-auto"></i>
                            </span>
                        </span>
                    </div>
        </div>

        {{-- <div class="form-group mb-1">
            <label for="nama_modul">Tambah Alat</label>
            <div class="input-group">
                <select class="selectpicker form-control w-100" name="alat[]" id="alat" multiple data-live-search="true">
                    @foreach ($alat as $a )
                        <option value="{{ $a->id_alat }}">{{ $a->nama_alat }}{{' '.$a->merk }}{{' '.$a->ukuran }}</option>
                    @endforeach
                </select>
            </div>
        </div> --}}
        <div class="listalat">
            <div class="col form-group mb-1">
                <label for="tambah">Tambah Alat</label>
            <button class="w-100 btn btn-md btn-primary " id="add_button_alat" type="button">+ alat +</button>
            </div>
            <div class="clonealat row align-items-start">
                <div class="col-8 form-group mb-1">
                    <label for="nama_modul">Pilih Alat</label>
                    <div class="alat_wrapper">
                        <div class="clone_alat">
                            <div class="input-group">
                                <select class="form-control w-50" name="id_alat[]" id="alat" data-live-search="true" data-dropup-auto="false" required>
                                    @foreach ($alat as $a )
                                        <option value="{{ $a->id_alat_praktikum }}">{{ $a->nama_alat }} - Stock Alat = {{' '.$a->jumlah  }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3 form-group mb-1">
                    <label for="jumlah_bahan">Jumlah Alat</label>
                    <input type="number" name="jumlah_alat[]" class="form-control" placeholder="Masukkan Jumlah Alat" required>
                </div>
            </div>
        </div>
        <div class="listbahan">
            <div class="col form-group mb-1">
                <label for="tambah">Tambah Bahan</label>
            <button class="w-100 btn btn-md btn-warning " id="add_button_bahan" type="button">+ bahan +</button>
            </div>
            <div class="clonebahan row align-items-start">
                <div class="col-8 form-group mb-1">
                    <label for="nama_modul">Pilih Bahan</label>
                    <div class="bahan_wrapper">
                        <div class="clone_bahan">
                            <div class="input-group">
                                <select class="form-control w-50" name="id_bahan[]" id="bahan" data-live-search="true" data-dropup-auto="false" required>
                                    @foreach ($bahan as $b )
                                        <option value="{{ $b->id_bahan }}">{{ $b->nama_bahan }}{{' '.$b->rumus }} - Stock Bahan = {{' '.$b->jumlah  }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3 form-group mb-1">
                    <label for="jumlah_bahan">Jumlah Bahan</label>
                    <input type="number" name="jumlah_bahan[]" class="form-control" placeholder="Masukkan Jumlah Bahan" required>
                </div>
            </div>
        </div>

        <button class="btn btn-md btn-primary d-flex justify-content-end" type="submit">Buat Modul</button>
    </div>

    </form>
</div>
<!-- end of from area -->
</div>
<!-- end of col -->
</div>
<!-- end of row -->
</div>
@endsection

@push('styles')
    <link href="{{ asset('select/css/bootstrap-select.min.css')}}" rel="stylesheet">
@endpush

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>-->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>-->

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>-->

<script type="text/javascript">
    $(function() {
        // $('#tanggal_praktek',).datepicker(
        //     {format:'yyyy-mm-dd'}
        // );

        $('.datepicker').datepicker({
        startDate: new Date()
        });;

        // add bahan when
        $('#add_button_bahan').on('click', function() {
            let bahanPicker = $('.clonebahan').first().clone()
            console.log(bahanPicker)
            let wrapper = $('.listbahan')
            console.log('wrapper' ,wrapper)
            $('.listbahan').append(bahanPicker)
        })


        // add bahan when
        $('#add_button_alat').on('click', function() {
            let alatPicker = $('.clonealat').first().clone()
            console.log(alatPicker)
            let wrapper = $('.listalat')
            console.log('wrapper' ,wrapper)
            $('.listalat').append(alatPicker)
        })
    });
</script>
