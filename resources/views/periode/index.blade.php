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
    <h3 class="title my-3">List Periode Praktikum</h3>
    <a class="btn btn-success my-3 ms-auto" href="/periode/create" role="button">Buat Periode</a>
</div>

<table id="example" class="display" style="width:100%">
    <thead>
        <tr class="text-center">
            <th>#</th>
            <th>Tahun Ajaran/Semester</th>
            <th>Waktu Pelaksanaan</th>
            <th>Status Periode</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($periode as $per )

        <tr>
            <td>{{ $loop->iteration  }}</td>
            <td>{{ $per->tahun_ajaran }} | {{ $per->semester }}</td>
            <td>{{ \Carbon\Carbon::parse($per->start_periode)->isoFormat('Do MMMM YYYY' )}} ~ {{ \Carbon\Carbon::parse($per->end_periode)->isoFormat('Do MMMM YYYY' )}}</td>
            <td>{{ $per->status_periode}} </td>
            <td>
                <a href="/editperiode/{{ $per->id_periode }}" class="badge bg-info"><span data-feather="edit"></span></a>
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




