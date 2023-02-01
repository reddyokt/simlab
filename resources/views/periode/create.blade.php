@extends('dashboard.layouts.main')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
{{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"> --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@section('container')
    <h3 class="h5 my-3 fw-normal text-center">Buat Periode</h3>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error )
            <li> {{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <form action="/periode/create" method="POST" class="col-md-5 d-block text-center mx-auto">
        @csrf
        <div class=" form-floating mb-1 ">
            <select class="form-control" name="tahun_ajaran" id="tahun_ajaran" >
                <option selected value="{{ old ('tahun_ajaran') }}" disabled>Tahun Ajaran</option>
                <?php
                $year = now()->year;
                ?>
                    <option value="{{$year-1}} - {{$year}}">{{$year-1}} / {{$year}}</option>
            </select>
            @error('tahun_ajaran')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
             @enderror
        </div>

        <div class=" form-floating mb-1 ">
            <select class="form-control" name="semester" id="semester" required  >
                <option value="{{ old ('semester') }}" selected disabled>Semester</option>
                <option value="Ganjil">Ganjil</option>
                <option value="Genap">Genap</option>
            </select>
            @error('semester')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
             @enderror
        </div>

        <div class="form-group mb-1">
            <label for="date" class="col-sm-12 col-form-label text-start">Start Periode</label>
            <div >
                    <input class="form-control col-sm-12" type="text" id="txtFrom" name="startdate"/>
            </div>
        </div>
        <div class="form-group mb-1">
            <label for="date" class="col-sm-12 col-form-label text-start">End Periode</label>
            <div >
                    <input class="form-control col-sm-12" type="text" id="txtTo" name="enddate"/>
            </div>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Tambah Periode</button>
    </form>
@endsection

<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.6/jquery.min.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"
type="text/javascript"></script>
<link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css"
rel="Stylesheet"type="text/css"/>
<script type="text/javascript">
$(function () {
    $("#txtFrom").datepicker({
        numberOfMonths: 1,
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() + 1);
            $("#txtTo").datepicker("option", "minDate", dt);
        }
    });
    $("#txtTo").datepicker({
        numberOfMonths: 1,
        onSelect: function (selected) {
            var dt = new Date(selected);
            dt.setDate(dt.getDate() - 1);
            $("#txtFrom").datepicker("option", "maxDate", dt);
        }
    });
});
</script>
