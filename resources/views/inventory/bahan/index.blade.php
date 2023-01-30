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
            <h3 class="title my-3">Daftar Bahan Kimia</h3>
        </div>
    </div>
    <div class="row ">
        <div class="col-sm-2">
            <a class="btn  btn-sm btn-success my-3 ms-auto" href="/bahan/create" role="button">Tambah Bahan Kimia</a>
        </div>
        <div class="col-sm-2 mt-3">
        <form action="/export/bahan" target="_blank" method="post">
            @csrf
            <button class="btn btn-sm btn-primary" role="button"><i class="fa fa-file-pdf-o"></i>  export bahan</button>
        </form>
        </div>
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
            <a href="/bahan/edit/{{ $b->id_bahan }}" class="badge bg-info"><span data-feather="edit"></span></a>
            {{-- <a href="" class="badge bg-danger"><span data-feather="x-circle"></span></a> --}}
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




