@extends('dashboard.layouts.main')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@section('container')
    <h3 class="h5 my-3 fw-normal text-center">Buat Periode</h3>
    <form action="/editperiode/{{ $periode->id_periode }}" method="POST" class="col-md-5 d-block text-center mx-auto">
        @csrf
        <div class="form-group mb-1">
            <label for="date" class="col-sm-12 col-form-label text-start">Tahun Ajaran</label>
            <div class="col-sm-12">
                    <input type="text" class="form-control" name="startdate" value="{{ $periode->tahun_ajaran }}" disabled>
            </div>
        </div>

        <div class="form-group mb-1">
            <label for="date" class="col-sm-12 col-form-label text-start">Semester</label>
            <div class="col-sm-12">
                    <input type="text" class="form-control" name="startdate" value="{{ $periode->semester }}" disabled>
            </div>
        </div>

        <div class="form-group mb-1">
            <label for="date" class="col-sm-12 col-form-label text-start">Start Periode</label>
            <div class="col-sm-12">
                <div class="input-group date" id="startdate" name="start_periode"  required>
                    <input type="text" class="form-control" name="start_periode" value="{{ $periode->start_periode }}">
                    <span class="input-group-append ">
                        <span class="input-group-text bg-white ">
                            <i class="fa fa-calendar mx-auto"></i>
                        </span>
                    </span>
                </div>
            </div>
        </div>
        <div class="form-group mb-1">
            <label for="date" class="col-sm-12 col-form-label text-start">End Periode</label>
            <div class="col-sm-12">
                <div class="input-group date" id="enddate" name="end_periode"  required>
                    <input type="text" class="form-control" name="end_periode" value="{{ $periode->end_periode }}">
                    <span class="input-group-append ">
                        <span class="input-group-text bg-white ">
                            <i class="fa fa-calendar mx-auto"></i>
                        </span>
                    </span>
                </div>
            </div>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Ubah Periode</button>
    </form>
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script type="text/javascript">
    $(function() {
        $('#startdate',).datepicker({format:'yyyy-mm-dd'});
        $('#enddate',).datepicker({format:'yyyy-mm-dd'});

    });
</script>
