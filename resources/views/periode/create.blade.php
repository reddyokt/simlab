@extends('dashboard.layouts.main')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
@section('container')
    <h3 class="h5 my-3 fw-normal text-center">Buat Periode</h3>
    <form action="/periode/create" method="POST" class="col-md-5 d-block text-center mx-auto">
        @csrf
        <div class=" form-floating mb-1 ">
            <select class="form-control" name="tahun_ajaran" id="tahun_ajaran" >
                <option selected value="{{ old ('tahun_ajaran') }}" disabled>Tahun Ajaran</option>
                <?php
                $year = date('2022')+10;
                ?>
                @for($i=date('2022');$i<=$year;$i++)
                    <option value="{{$i}} - {{$i+1}}">{{$i}} / {{$i+1}}</option>
                @endfor
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
            <div class="col-sm-12">
                <div class="input-group date" id="startdate" name="startdate"  required>
                    <input type="text" class="form-control" name="startdate" value="{{ old ('startdate') }}">
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
                <div class="input-group date" id="enddate" name="enddate"  required>
                    <input type="text" class="form-control" name="enddate" value="{{ old ('enddate') }}">
                    <span class="input-group-append ">
                        <span class="input-group-text bg-white ">
                            <i class="fa fa-calendar mx-auto"></i>
                        </span>
                    </span>
                </div>
            </div>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Tambah Periode</button>
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
