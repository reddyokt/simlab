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

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error )
        <li> {{ $error }}</li>
        @endforeach
    </ul>
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
         <td>{{ $dt->praktikum->nama_kelas }} - {{ $dt->kelas->kelas->nama_kelas }}</td>
         <td>{{ $dt->nama_modul }}</td>
         <td>{{\Carbon\Carbon::parse($dt->tanggal_praktek)->isoFormat('Do MMMM YYYY' )}}</td>
         <td>{{ $dt->kelas->dosen->nama_dosen }}</td>
         <td>
             <a href="#" class="badge bg-success" data-bs-toggle="modal" data-bs-target="#Modaldetail-{{ $dt->id_modul }}"><span data-feather="eye"></span></a>
             @if (!$dt->used)
                <a href="/modul/usemodul/{{ $dt->id_modul }}" class="badge bg-warning"><span data-feather="sunrise" onclick="return confirm('Yakin akan menggunakan modul ini?!!!')"></span></a>
                <a href="/modul/editmodul/{{ $dt->id_modul }}" class="badge bg-info"><span data-feather="edit"></span></a>
                <a href="#" class="badge bg-danger"><span data-feather="x-circle"></span></a>
             @else
                @if (!$dt->catatan)
                    <a href="/modul/catatan/{{ $dt->id_modul }}" class="badge bg-primary" data-bs-toggle="modal" data-bs-target="#Modaldetail2-{{ $dt->id_modul }}"><span data-feather="pen-tool"></span></a>
                    @else
                    <a href="/modul/editcatatan/{{ $dt->id_modul }}" class="badge bg-WARNING" data-bs-toggle="modal" data-bs-target="#Modaldetail3-{{ $dt->id_modul }}"><span data-feather="pen-tool"></span></a>
                @endif

             @endif


         </td>
     </tr>
        @endforeach
    </tbody>
</table>

<!-- Modal -->
@foreach ($dataModul as $dt )

<div class="modal fade" id="Modaldetail-{{ $dt->id_ }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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

<!-- Modal2 -->
@foreach ($dataModul as $dt )
<div class="modal fade bd-example-modal-lg " id="Modaldetail2-{{ $dt->id_modul }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Catatan Kegiatan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/modul/catatan/{{ $dt->id_modul }}" method="POST" class="col-md d-block align-item-center mx-auto">
            @csrf
        <div class="modal-body">
            <input type="hidden" value="{{ $dt->id_modul }}" name="modul_id">
            <div class="form-group row mb-3">
                <div class="col-12">
                    <input class="form-control" id="{{ $dt->id_modul }}" type="hidden" name="catatan" required>
                    <trix-editor input="{{ $dt->id_modul }}"></trix-editor>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-md btn-primary d-flex justify-content-end" type="submit">Buat Catatan</button>
        </div>
      </div>
    </div>
  </div>
</form>
@endforeach

<!-- Modal2 -->
@foreach ($dataModul as $dt )
{{-- @dump ($dt) --}}
<div class="modal fade bd-example-modal-lg " id="Modaldetail3-{{ $dt->id_modul }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg ">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Catatan Kegiatan</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/modul/editcatatan/{{ $dt->id_modul }}" method="POST" class="col-md d-block align-item-center mx-auto">
            @csrf
        <div class="modal-body">
            <input type="hidden" value="{{ $dt->id_modul }}" name="modul_id">
            <div class="form-group row mb-3">
                <div class="col-12">
                    <input class="form-control" id="edit/{{ $dt->id_modul }}" type="hidden" name="editcatatan" required>
                    <trix-editor input="edit/{{ $dt->id_modul }}">
                        {!! $dt->catatan ? $dt->catatan->isi_catatan  : "" !!}
                    </trix-editor>
                </div>
            </div>
        </div>
        <div class="modal-footer">
            <button class="btn btn-md btn-primary d-flex justify-content-end" type="submit">Edit Catatan</button>
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




