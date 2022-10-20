@extends('dashboard.layouts.main')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


@section('container')
    <h3 class="h5 my-3 fw-normal text-center">Tambah Modul Praktikum</h3>
    <form action="/modul/createmodul" method="POST" class="col-md-5 d-block align-item-center mx-auto">
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
            <select class="form-control" name="kelas_id" id="kelas_id" required >
                <option selected disabled>Pilih Kelas</option>
            @foreach ( $kelas as $dt )
                <option value="{{ $dt->id_praktikum }}">{{ $dt->nama_kelas }}</option>
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
                        <input type="text" class="form-control" name="tanggal_praktek" value="{{ old ('tanggal_praktek') }}">
                        <span class="input-group-append ">
                            <span class="input-group-text bg-white ">
                                <i class="fa fa-calendar mx-auto"></i>
                            </span>
                        </span>
                    </div>
        </div>

        <div class="form-group mb-1">
            <label for="nama_modul">Tambah Alat</label>
            <div class="input-group">
                <select class="selectpicker form-control w-100" name="alat[]" id="alat" multiple data-live-search="true">
                    @foreach ($alat as $a )
                        <option value="{{ $a->id_alat }}">{{ $a->nama_alat }}{{' '.$a->merk }}{{' '.$a->ukuran }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Buat Modul</button>
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
        $('#tanggal_praktek',).datepicker(
            {format:'yyyy-mm-dd'}
        );
    });
</script>
