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
    <h3 class="title my-3">Daftar SOP/Modul</h3>
    <a class="btn btn-success my-3 ms-auto" href="/download/create" role="button">Upload SOP/Modul</a>
</div>

<table id="example" class="display" style="width:100%; font-size:12px;">
    <thead>
        <tr>
            <th>#</th>
            <th>Judul File</th>
            <th>Uraian File</th>
            <th class="d-flex justify-content-center">Download File</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
       @foreach ( $download as $d )
        <tr>
            <td>{{ $loop->iteration  }}</td>
            <td>{{ $d->judul_file }}</td>
            <td>{!! $d->uraian_file !!}</td>
            <td class="d-flex justify-content-center"><a href="{{ $d->pdf }}" target="_blank"><span data-feather="file"></a></td>
            <td>
                <a href="/mhs/" class="badge bg-info"><span data-feather="edit"></span></a>
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

