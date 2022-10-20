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
    <h3 class="title my-3">Daftar Peserta Praktikum</h3>

</div>

<div class="card-body">
    <table id="example" class="display" style="width:100%">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
                <th>Praktikum Dipilih</th>
                <th>Status</th>

            </tr>
        </thead>
        <tbody>
            @foreach ($dataMhs as $key=>$d)

            <tr>
                <td>{{ $loop->iteration  }}</td>
                <td>{{ $d->nama_mahasiswa}}</td>
                <td>{{ $d->nim }}</td>
                <td>{{ $d->nama_kelas }}</td>
                <td>{{ $d->status }}</td>

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




