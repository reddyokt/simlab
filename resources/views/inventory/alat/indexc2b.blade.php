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
    <!--a class="btn btn-success my-3 ms-auto" href="/inventory/alat/createalatc2a" role="button">Tambah Alat C2A</a>
    <a class="btn btn-success my-3 ms-auto" href="/inventory/alat/createalatc2b" role="button">Tambah Alat C2B</a>
    <a class="btn btn-success my-3 ms-auto" href="/inventory/alat/createlemari" role="button">Tambah Lemari/Lokasi</a>-->
</div>

<div class="card ">
    <div class="card-header bg-info">
      <h5 class="card-title"> Daftar Alat C2B</h5>
    </div>
    <div class="card-body ">

        {{--<table id="example2" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Alat</th>
                        <th>Merk</th>
                        <th>Jumlah</th>
                        <th>Lokasi</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $c2b_alat as $alat )
                    <tr>
                        <td>{{ $loop->iteration  }}</td>
                        <td>{{ $alat->nama_alat_c2b }}</td>
                        <td>{{ $alat->merk }}</td>
                        <td>{{ $alat->jumlah }}</td>
                        <td>{{ $alat->lokasi->nama_lokasi }}</td>
                        <td>
                            <a href="/alatc2b/{{ $alat->id_alat_c2b }}" class="badge bg-info"><span data-feather="edit"></span></a>
                            <a href="/deletec2b/{{ $alat->id_alat_c2b }}" class="badge bg-danger" onclick="return confirm('Yakin akan menghapus data Alat?!!!')" ><span data-feather="x-circle"></span></a>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>--}}

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




