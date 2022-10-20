@extends('dashboard.layouts.main')


<link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/css/bootstrap-select.min.css" rel="stylesheet">
<link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>


@section('container')
    <h3 class="h5 my-3 fw-normal text-center">Tambah Alat & Bahan Modul Praktikum</h3>
    <form action="/modul/addItem" method="POST" class="col-md-5 d-block text-center mx-auto">
        @csrf
        <div class="invisible">
            <input type="text" name="modul_id" class="form-control"
            id="modul_id" placeholder="Modul ID"  value="{{ $modul->id_modul }}">
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="nama_modul" class="form-control"
            id="nama_modul" placeholder="Nama modul"  value="{{ $modul->nama_modul }}" disabled >
            <label for="name">Nama Modul</label>
        </div>
        <div class="form-floating row mt-2">
            <select class="selectpicker col-md-12 form py-2" name="alatc2a[]" id="alatc2a" multiple data-live-search="true">
                @foreach ($alatA as $a )
                    <option value="{{ $a->id_alat }}" @if (in_array($a->id_alat,old('alatc2a',[]))) selected="selected"@endif>{{ $a->nama_alat }}</option>
                @endforeach
            </select>
            <label class="py-1" for="alatc2a">Tambah Alat C2A</label>
        </div>
        <div class="form-floating row mt-2">
            <select class="selectpicker col-md-12 form py-2" name="alatc2b[]" id="alatc2b" multiple data-live-search="true">
                @foreach ($alatB as $b )
                <option value="{{ $b->id_alat }}" @if (in_array($b->id_alat,old('alatc2b',[]))) selected="selected"@endif>{{ $b->nama_alat }}</option>
                @endforeach
            </select>
            <label class="py-1" for="alatc2b">Tambah Alat C2B</label>
        </div>



        <button class="w-100 btn btn-lg btn-primary" type="submit">Buat Alat & Bahan Modul</button>
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

{{--  @push('scripts')
    $('.selectpicker'). selectpicker();
    <script type="text/javascript" src="{{ asset('select/js/bootstrap-select.min.js') }}"></script>
@endpush--}}

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.14.0-beta2/js/bootstrap-select.min.js"></script>


