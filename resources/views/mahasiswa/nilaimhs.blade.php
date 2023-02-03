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
    <h3 class="title my-3">Data Nilai</h3>
</div>
<form action="/export/absen" target="_blank" method="post">
    @csrf
    <div class="row mt-3">
        <div class="col-3">
            <select class="form-control" name="id_praktikum">
                <option value=""></option>
            </select>
        </div>
        <div class="col-2">
            <button type="submit" class="btn btn-sm btn-primary" role="button"> Lihat Nilai </button>
        </div>
    </div>
</form>

<div class="mt-5">
    <table id="example" class="display table table-bordered" style="width:100%; border: 1px solid black;">
        <thead>
            <tr>
                <td style="text-align: center;" colspan="10"><b>Nilai Praktikum Kelas A<b></td>
            </tr>
            <tr>
                <th>#</th>
                <th>Nama Modul</th>
                <th>Pre Test</th>
                <th>Post Test</th>
                <th>Subjektif</th>
                <th>Laporan</th>
                <th>Ujian Awal</th>
                <th>Ujian akhir</th>
                <th>Ujian Awal</th>
                <th>Ujian Lisan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ( $data as $dt )

            <tr>
                <td>{{ $loop->iteration  }}</td>
                <td>A</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
                <td rowspan="2" style="padding:30px; text-align:center;">100</td>
                <td rowspan="2" style="padding:30px; text-align:center;">100</td>
                <td rowspan="2" style="padding:30px; text-align:center;">100</td>
                <td rowspan="2" style="padding:30px; text-align:center;">100</td>
            </tr>
            <tr>
                <td>{{ $loop->iteration  }}</td>
                <td>B</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
                <td>100</td>
            </tr>
            <tr>
                <td style="text-align: end;" colspan="9"><b>Nilai Akhir<b></td>
                <td style="text-align:center;"><b>100<b></td>
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




