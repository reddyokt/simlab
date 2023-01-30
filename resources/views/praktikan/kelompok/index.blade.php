@extends('dashboard.layouts.main')

@section('container')

<!-- Custom styles for this datatables -->
<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

@if (session()-> has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    <h3 class="title my-3">Daftar Kelompok</h3>
                </div>
            </div>
            <div class="row ">
                <div class="col-sm-2">
                    <a class="btn btn-sm btn-success my-3 ms-auto" href="/praktikan/createkelompok" role="button">Buat Kelompok</a>
                </div>
                <div class="col-sm-2 mt-3">
                <form action="/export/kelompok" target="_blank" method="post">
                    @csrf
                    <button class="btn btn-sm btn-primary" role="button"><i class="fa fa-file-pdf-o"></i> export kelompok</button>
                </form>
                </div>
          </div>
        <div class="row">
            <div class="col">

            </div>
            <div class="col">

            </div>
         </div>

<table id="example" class="display" style="width:100%; font-size:12px;">
    <thead>
        <tr>
            <th>#</th>
            <th>Kelompok</th>
            <th>Nama Kelas</th>
            <th>Nama Mahasiswa</th>
            <th>NIM</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ( $datakelompok as $mhs )
        <tr>
            <td>{{ $loop->iteration  }}</td>
            <td>{{ $mhs->kelompok->nama_kelompok }}</td>
            <td>{{ $mhs->kelompok->praktikum->kelas->nama_kelas }}</td>
            <td>{{ $mhs->mahasiswa->nama_mahasiswa }}</td>
            <td>{{ $mhs->mahasiswa->nim }}</td>
            <td>
                <a href="/praktikan/editkelompok/{{ $mhs->mahasiswa_id }}/{{ $mhs->praktikum_id }}" class="badge bg-info"><span data-feather="edit"></span></a>
                {{-- <a href="/delete/{{ $mhs->mahasiswa_id }}/{{ $mhs->praktikum_id }}" class="badge bg-danger" onclick="return confirm('Yakin akan menghapus data Mahasiswa?!!!')"><span data-feather="x-circle"></span></a> --}}
            </td>
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

