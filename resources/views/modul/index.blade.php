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
    <h3 class="title my-3">List Modul</h3>
    <a class="btn btn-success my-3 ms-auto" href="/modul/createmodul" role="button">Tambah Modul</a>
</div>

<table id="example" class="display" style="width:100%">
    <thead>
        <tr>
            <th>#</th>
            <th>Nama Kelas</th>
            <th>Nama Modul</th>
            <th>Jadwal Praktek</th>
            <th>Dosen Pengampu</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($dataModul as $key=>$dt )

        <tr>
         <td>{{ $loop->iteration  }}</td>
         <td>{{ $dt->kelas->kelas->nama_kelas }}</td>
         <td>{{ $dt->nama_modul }}</td>
         <td>{{ $dt->tanggal_praktek }}</td>
         <td>{{ $dt->kelas->dosen->nama_dosen }}</td>
         <td>
             <a href="#" class="badge bg-success" data-bs-toggle="modal" data-bs-target="#Modaldetail-{{ $dt->id_modul }}"><span data-feather="eye"></span></a>
             <a href="#" class="badge bg-info"><span data-feather="edit"></span></a>
             <a href="#" class="badge bg-danger"><span data-feather="x-circle"></span></a>
         </td>
     </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal -->
@foreach ($dataModul as $dt )

<div class="modal fade" id="Modaldetail-{{ $dt->id_modul }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Alat dan Bahan {{ $dt->nama_modul }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">

            <table class="table">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Nama Alat</th>
                  </tr>
                </thead>
                <tbody>
                    {{-- dd($dt->alat()) --}}
                    @foreach ($dt->alat as $x  )
                    <tr>
                      <th scope="row">{{$loop->iteration}}</th>
                      <td>{{ $x->nama_alat}}-{{ $x->ukuran}}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            <table class="table">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nama Bahan</th>
                </tr>
              </thead>
              <tbody>
                    {{-- dd($dt->alat()) --}}
                    @foreach ($dt->membermodul()->where('bahan_id',"!=",0)->get() as $y)

                    <tr>
                        <th scope="row">{{$loop->iteration}}</th>
                        <td>{{ $y->bahan->nama_bahan}} = {{ $y->jumlah_bahan }}</td>
                    </tr>
                    @endforeach
              </tbody>
          </table>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
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




