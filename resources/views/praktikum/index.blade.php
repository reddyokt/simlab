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
            <th>Asisten Lab</th>
            {{-- <th >Kelas Aktif?</th> --}}
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
    @foreach ($praktikums as $praktik )
        <tr>
            <td>{{ $loop->iteration  }}</td>
            <td>{{ $praktik->nama_kelas }} - {{ $praktik->kelas->nama_kelas }}</td>
            <td>{{ $praktik->periode->semester}} | {{ $praktik->periode->tahun_ajaran}}</td>
            <td>{{ $praktik->kelas->jumlah_modul }}</td>
            <td>{{ $praktik->dosen->nama_dosen}} <br> {{ $praktik->dosen->nidn}}  </td>
            <td>{{ $praktik->asisten ? $praktik->asisten->nama_lengkap : "Belum ada Asisten Lab" }}</td>
            <td>
                <a href="/praktikum/editekelas/{{ $praktik->id_praktikum }}" class="badge bg-info"><span data-feather="edit"></span></a>
                <a href="" class="badge bg-success" data-bs-toggle="modal" data-bs-target="#Modaldetail-{{ $praktik->id_praktikum }}">
                    <span data-feather="user"></span></a>
                <a href="/praktikum/deletekelas/{{ $praktik->id_praktikum }}" class="badge bg-danger" onclick="return confirm('Yakin akan menghapus data Kelas?!!!')"><span data-feather="x-circle"></span></a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
@foreach ( $praktikums as $praktik )
<div class="modal fade" id="Modaldetail-{{ $praktik->id_praktikum }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Penugasan Asisten Lab</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/praktikum/aslab" method="POST">
            @csrf
        <div class="modal-body">
                <input type="hidden" value="{{ $praktik->id_praktikum }}" name="id_praktikum">
                <select class="form-control" name="asisten_id">
                        <option selected>Pilih Asisten Lab</option>
                    @foreach ( $aslab as  $as)
                        <option value="{{ $as->id }}">{{ $as->nama_lengkap }}</option>
                    @endforeach
                </select>
        </div>

        <div class="modal-footer">
            <button type="submit" class="btn btn-success">Simpan</button>
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
        </form>
      </div>
    </div>
  </div>
  @endforeach

@endsection
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
    $('#example').DataTable();
});</script>




