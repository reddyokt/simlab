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

<div>
    <h3 class="title my-3">Daftar Jawaban Tugas Praktikan</h3>
</div>

<table id="example" class="display" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Mahasiswa</th>
            <th>Nama Kelas</th>
            <th>Nama Modul</th>
            <th>Jenis Tugas</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($data as $dt )
        <tr>
                <td>{{ $loop->iteration  }}</td>
                <td>{{ $dt->mahasiswa->nama_mahasiswa}}</td>
                <td>{{ $dt->praktikum->kelas->nama_kelas}}</td>
                <td>{{ $dt->praktikum->modul}}</td>
                <td>{{ $dt->praktikum->modul}}</td>
                <td>
                    <a href="" class="badge bg-info"><span data-feather="download"></span></a>
                    <a href="" class="badge bg-danger"><span data-feather="eye"></span></a>
                </td>
        </tr>
        @endforeach

    </tbody>
</table>

@endsection
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
    $('#example').DataTable();
});</script>

