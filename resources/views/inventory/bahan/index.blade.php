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

<table id="example" class="display" style="width:100% font-size:12px">
    <thead>
        <tr>
            <th style="font-size:12px">#</th>
            <th style="font-size:12px">Nama Bahan</th>
            <th style="font-size:12px">Rumus Kimia</th>
            <th style="font-size:12px">Lokasi</th>
            <th style="font-size:12px">Jumlah</th>
            <th style="font-size:12px">Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($bahan as $b )

    <tr>
        <td style="font-size:12px">{{ $loop->iteration }}</td>
        <td style="font-size:12px">{{ $b->nama_bahan }}</td>
        <td style="font-size:12px">{{ $b->rumus }}</td>
        <td style="font-size:12px">{{ $b->lokasi_id }}</td>
        <td style="font-size:12px">{{ $b->jumlah }}</td>
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




