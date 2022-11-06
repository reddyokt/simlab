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
    <h3 class="title my-3">Daftar Bahan Kimia</h3>
    <a class="btn btn-success my-3 ms-auto" href="/bahan/create" role="button">Tambah Bahan Kimia</a>
</div>

<table id="example" class="display" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Bahan</th>
            <th>Rumus Kimia</th>
            <th>Lokasi</th>
            <th>Jumlah</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($bahan as $b )

    <tr>
        <td>{{ $loop->iteration }}</td>
        <td>{{ $b->nama_bahan }}</td>
        <td>{{ $b->rumus }}</td>
        <td>{{ $b->lokasi_id }}</td>
        <td>{{ $b->jumlah }}</td>
        <td>
            <a href="" class="badge bg-info"><span data-feather="edit"></span></a>
            <a href="" class="badge bg-danger"><span data-feather="x-circle"></span></a>

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




