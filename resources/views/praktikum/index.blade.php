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
    <h3 class="title my-3">List Kelas Praktikum</h3>
    <a class="btn btn-success my-3 ms-auto" href="/praktikum/createkelas" role="button">Tambah Kelas Praktikum</a>
</div>

<table id="example" class="display" style="width:100%">
    <thead>
        <tr class="text-center">
            <th>#</th>
            <th>Nama Kelas</th>
            <th>Tahun Ajaran</th>
            <th>Jumlah Modul</th>
            <th>Dosen Pengampu</th>
            {{-- <th >Kelas Aktif?</th> --}}
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($praktikums as $praktik )
        <tr>
            <td>{{ $loop->iteration  }}</td>
            <td>{{ $praktik->kelas->nama_kelas }}</td>
            <td>{{ $praktik->periode->semester}} | {{ $praktik->periode->tahun_ajaran}}</td>
            <td>{{ $praktik->jumlah_modul }}</td>
            <td>{{ $praktik->dosen->nama_dosen}} <br> {{ $praktik->dosen->nidn}}  </td>
            {{-- <td>{{ $praktik->is_active=='Y'?"Aktif" : "Tidak Aktif" }}</td> --}}
            <td>
                <a href="/praktikum/editekelas/{{ $praktik->id_praktikum }}" class="badge bg-info"><span data-feather="edit"></span></a>
                <a href="/praktikum/deletekelas/{{ $praktik->id_praktikum }}" class="badge bg-danger" onclick="return confirm('Yakin akan menghapus data Kelas?!!!')"><span data-feather="x-circle"></span></a>
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




