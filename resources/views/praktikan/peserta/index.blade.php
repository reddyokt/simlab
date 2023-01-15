@extends('dashboard.layouts.main')

@section('container')

<!-- Custom styles for this datatables -->
<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">

@if (session()-> has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="card mt-3">
    <div class="card-header bg-primary text-white">Import Data Calon Praktikan</div>
    <div class="card-body">
        <form action="/praktikan/import" method="post" enctype="multipart/form-data">
            @csrf
            <div class=" form-group mb-1 ">
                <select class="form-control" name="periode_id" id="periode_id" value="{{ old ('periode_id') }}">
                    <option selected disabled>Pilih Periode</option>
                    @foreach ( $periode as $per )
                    <option value="{{ $per->id_periode }}">{{ $per->tahun_ajaran }} | {{ $per->semester }}</option>
                    @endforeach
                </select>
                @error('periode_id')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div>
            </div>
            <div class="form-group row mb-3">
                <div class="col">
                    <input accept="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel"
                    class="form-control" type="file" id="dataimport" name="dataimport">
                </div>
            </div>
            <button class="btn btn-sm btn-success float-start " role="button">Import Data</button>
        </form>
    </div>
</div>

<h3 class="title my-3">Daftar Peserta Praktikum</h3>
<div class="card-body">
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>PERIODE</th>
                <th>NIM</th>
                <th>Nama Mahasiswa</th>
                <th>Praktikum Dipilih</th>

            </tr>
        </thead>
        <tbody>

            @foreach ($dataMhs as $key=>$d)

            <tr>
                <td>{{ $loop->iteration  }}</td>
                <td>{{ $d->praktikum->periode->tahun_ajaran }} | {{ $d->praktikum->periode->semester }}</td>
                <td>{{ $d->mahasiswa->nim }}</td>
                <td>{{ $d->mahasiswa->nama_mahasiswa}}</td>
                <td>{{ $d->praktikum->kelas->nama_kelas }}</td>

            </tr>

            @endforeach
        </tbody>
    </table>
</div>

@endsection
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
    $('#example').DataTable();
});</script>




