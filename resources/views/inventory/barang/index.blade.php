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
    <h3 class="title my-3">Daftar Barang Umum</h3>
    <a class="btn btn-success my-3 ms-auto" href="/inventory/barang/create" role="button">Tambah Barang</a>
</div>

<table id="example" class="display table table-striped" style="width:100%">
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
            <td>{{ $b->lokasi->nama_lokasi }}<br>
                - {{ $b->lokasi2->nama_lokasi }}</td>
            <td>
                <a href="/barang/{{$b->id_barang}}" class="badge bg-info"><span data-feather="edit"></span></a>
                <a href="/deletebarang/{{$b->id_barang}}" class="badge bg-danger" onclick="return confirm('Yakin akan menghapus data Alat?!!!')"><span data-feather="x-circle" ></span></a>

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




