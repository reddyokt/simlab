@extends('dashboard.layouts.main')

@section('container')
<link rel="stylesheet" type="text/css" href="/css/trix.css">
<script type="text/javascript" src="/js/trix.js"></script>
<!-- Custom styles for this datatables -->
<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">

@if (session()-> has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {!! session('success') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif


<div>
    <h3 class="title my-3">List Nama Praktikum</h3>
    <a class="btn btn-success my-3 ms-auto" href="/masterdata/createnamapraktikum" role="button">Tambah Nama Praktikum</a>
</div>

<div>
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Praktikum</th>
                <th>Kode Mata Kuliah</th>
                <th>Jumlah Modul</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $dt )

            <tr>
            <td>{{ $loop->iteration  }}</td>
            <td>{{ $dt->nama_kelas }}</td>
            <td>{{ $dt->kode_kelas }}</td>
            <td>{{ $dt->jumlah_modul }}</td>
            <td>{{ $dt->is_active == 'N' ? "Tidak Aktif" : "Aktif" }}</td>
            <td>
                    <a href="/masterdata/editnamapraktikum/{{ $dt->id_kelas }}" class="badge bg-info"><span data-feather="edit"></span></a>

                    <a href="/masterdata/deactivated/{{ $dt->id_kelas }}" class="badge bg-danger"><span data-feather="minus" onclick="return confirm('Yakin akan menon-aktifkan Praktikum ini?!!!')"></span></a>

                    <a href="/masterdata/activated/{{ $dt->id_kelas }}" class="badge bg-success"><span data-feather="activity" onclick="return confirm('Yakin akan meng-aktifkan Praktikum ini?!!!')"></span></a>

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




