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
        <div class="col-sm-4">
            <h3 class="title my-3">Daftar Barang Umum</h3>
        </div>
    </div>
    <div class="row ">
        <div class="col-sm-2">
            <a class="btn  btn-sm btn-success my-3 ms-auto" href="/bahan/create" role="button">Tambah Barang</a>
        </div>
        <div class="col-sm-2 mt-3">
        <form action="/export/barang" target="_blank" method="post">
            @csrf
            <button class="btn btn-sm btn-primary" role="button"><i class="fa fa-file-pdf-o"></i>  export Barang</button>
        </form>
        </div>
  </div>

<table id="example" class="display table table-striped" style="width:100% font-size:12px">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama</th>
            <th>Merk</th>
            <th>Ukuran</th>
            <th>Pabrikan</th>
            <th>Jumlah/Kondisi</th>
             <th>Lokasi</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($barang as $b )

              <tr>
            <td>{{ $loop->iteration  }}</td>
            <td>{{ $b->nama_barang }}</td>
            <td>{{ $b->merk_barang }}</td>
            <td>{{ $b->ukuran_barang }}</td>
            <td>{{ $b->pabrik_barang }}</td>
            <td>Jumlah : {{ $b->jumlah_barang }} <br> Rusak : {{ $b->barang_rusak }} </td>
            <td>{{ $b->lokasi->nama_lokasi }}</td>
            <td>
                <a href="/barang/{{$b->id_barang}}" class="badge bg-info"><span data-feather="edit"></span></a>
                <a href="/deletebarang/{{$b->id_barang}}" class="badge bg-danger" onclick="return confirm('Yakin akan menghapus data Alat?!!!')"><span data-feather="x-circle" ></span></a>

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




