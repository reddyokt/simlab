@extends('dashboard.layouts.main')

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@section('container')
<div class="card mt-2 col-md-6 align-item-center mx-auto d-block">
    <div class="card-header text-center mx-auto d-block">
      Tambah Modul Praktikum
    </div>
        <div class="card-body ">
         <form action="/modul/createmodul" method="POST" class="form-horizontal align-item-center">
            @csrf

            <div class="form-group">
                <div class="col-sm-4">
                  <label for="nama_modul" class="col-form-label" >Nama Modul</label>
                </div>
                <div class="col-sm-12">
                  <input type="text" id="nama_modul" name="nama_modul" class="form-control">
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-4">
                  <label for="kelas_id" class="col-form-label" >Pilih Kelas</label>
                </div>
                <div class="col-sm-12">
                  <select class="form-control col-sm-12">
                    <option>TEs</option>
                  </select>
                </div>
            </div>

            <div class="form-group">
                <div class="col-sm-4">
                  <label for="kelas_id" class="col-form-label" >Tanggal Praktek</label>
                </div>
                <div class="col-sm-12">
                    <div class="input-group date" id="tanggal_praktek" name="tanggal_praktek"  required>
                        <input type="text" class="form-control" name="tanggal_praktek" value="{{ old ('tanggal_praktek') }}">
                        <span class="input-group-append ">
                            <span class="input-group-text bg-white ">
                                <i class="fa fa-calendar mx-auto"></i>
                            </span>
                        </span>
                    </div>
                </div>
            </div>


            <button class="w-100 btn btn-lg btn-primary mt-2" type="submit">Buat Modul</button>



        </form>

        </div>
</div>


@endsection

@push('styles')
    <link href="{{ asset('select/css/bootstrap-select.min.css')}}" rel="stylesheet">
@endpush

@push('scripts')
    $('.selectpicker'). selectpicker();
    <script type="text/javascript" src="{{ asset('select/js/bootstrap-select.min.js') }}"></script>
@endpush

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

<script type="text/javascript">
    $(function() {
        $('#tanggal_praktek',).datepicker(
            {format:'yyyy-mm-dd'}
        );
    });
</script>
