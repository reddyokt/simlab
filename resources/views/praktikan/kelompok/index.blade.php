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
    <h3 class="title my-3">Daftar Kelompok</h3>
    <a class="btn btn-success my-3 ms-auto" href="/praktikan/createkelompok" role="button">Buat Kelompok</a>
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
                <a href="/delete/" class="badge bg-danger" onclick="return confirm('Yakin akan menghapus data Mahasiswa?!!!')"><span data-feather="x-circle"></span></a>
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

