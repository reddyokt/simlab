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
    <div>
        <a class="btn btn-success my-3 ms-auto" href="/createalat" role="button">Tambah Alat Praktikum</a>
        <a class="btn btn-success my-3 ms-auto" href="/inventory/alat/createlemari" role="button">Tambah Lemari/Lokasi</a>
    </div>

    <div class="row">
            <div class="col-md-2">
                <form action="/export/alatc2a" target="_blank" method="post">
                    @csrf
                    <button class="btn btn-sm btn-primary" role="button"><i class="fa fa-file-pdf-o"></i> export data Alat C2A</button>
                </form>
            </div>
            <div class="col-md-2">
                <form action="/export/alatc2b" target="_blank" method="post">
                    @csrf
                    <button class="btn btn-sm btn-primary" role="button"><i class="fa fa-file-pdf-o"></i> export data Alat C2B</button>
                </form>
            </div>
        </div>

    <div class="card mt-2 mb-10">
        <div class="card-header bg-warning">
        <h5 class="card-title"> Daftar Alat </h5>
        </div>
        <div class="card-body">

            <table id="example1" class="display" style="width:100%; font-size:12px;">
                <thead>
                    <tr>
                        <th style="font-size:12px">#</th>
                        <th style="font-size:12px">Nama Alat</th>
                        <th style="font-size:12px">Jenis Alat</th>
                        <th style="font-size:12px">Merk</th>
                        <th style="font-size:12px">Ukuran</th>
                        <th style="font-size:12px">Jumlah</th>
                        <th style="font-size:12px">Lokasi</th>
                        <th style="font-size:12px">Action</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($alat as $a )
                @foreach ($a->kategori as $kategori )
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="font-size:12px">{{ $a->nama_alat }}</td>
                    <td style="font-size:12px">{{ $kategori->nama_kategori}}</td>
                    <td style="font-size:12px">{{ $a->merk }}</td>
                    <td style="font-size:12px">{{ $a->ukuran }}</td>
                    <td style="font-size:12px">{{ $a->jumlah }}</td>
                    <td style="font-size:12px"> {{ $a->lokasi->nama_lokasi }}<br>Lemari : {{ $a->lemari}}.{{ $a->baris }}.{{ $a->kolom }}</td>
                    <td>
                        <a href="/editalat/{{ $a->id_alat }}" class="badge bg-info"><span data-feather="edit"></span></a>
                        <a href="/deletealat/{{ $a->id_alat }}" class="badge bg-danger" onclick="return confirm('Yakin akan menghapus data Alat?!!!')"><span data-feather="x-circle"></span></a>
                    </td>
                </tr>
                @endforeach
                @endforeach
                </tbody>
            </table>
        </div>
    </div>






@endsection
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
    $('#example1').DataTable();
});</script>
<script type="text/javascript">
    $(document).ready(function () {
    $('#example2').DataTable();
});</script>




