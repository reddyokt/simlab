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
    <div class="row mt-5">
            <div class="col-md-2">
                <form action="/export/transaksi" target="_blank" method="post">
                    @csrf
                    <button class="btn btn-sm btn-primary" role="button"><i class="fa fa-file-pdf-o"></i> export data</button>
                </form>
            </div>
    <div class="card mt-2 mb-10">
        <div class="card-header bg-warning text-center">
            <h5 class="card-title "> Daftar Transaksi Penggunaan Alat dan Bahan Praktikum</h5>
        </div>
        <div class="card-body">
            <table id="example1" class="display" style="width:100%; font-size:12px;">
                <thead>
                    <tr>
                        <th style="font-size:12px">#</th>
                        <th style="font-size:12px">Nama Kelas - Modul</th>
                        <th style="font-size:12px">Alat Dipakai</th>
                        <th style="font-size:12px">Bahan Dipakai</th>
                        <th style="font-size:12px">Catatan Praktikum</th>
                    </tr>
                </thead>
                <tbody>
                @foreach ($data as $dt )
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td style="font-size:12px">{{$dt->praktikum->kelas->nama_kelas }} - {{$dt->nama_modul }}</td>

                    <td style="font-size:12px">
                        @foreach ($dt->alat as $member)
                        {{ $member->nama_alat }} - {{ $member->ukuran }}<br>
                        @endforeach
                    </td>
                    <td style="font-size:12px">
                        @foreach ($dt->bahan as $member)
                        {{ $member->nama_bahan }} - {{ $member->pivot->jumlah_bahan }}<br>
                        @endforeach
                    </td>
                    {{-- @dd($dt->catatan->toArray()) --}}
                    <td style="font-size:12px">
                         {!! $dt->catatan->isi_catatan !!}
                    </td>
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




