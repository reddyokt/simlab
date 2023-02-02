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
    <h3 class="title my-3">List Komponen Nilai</h3>
</div>

<div>
    <table id="example" class="display" style="width:50%">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Komponen</th>
                <th>Nilai Komponen</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $dt )
            <tr>
                <td>{{ $loop->iteration  }}</td>
                <td>{{ $dt->nama_komponen }}</td>
                <td>{{ $dt->nilai_komponen }} %</td>
                <td>
                        <a href="#" class="badge bg-success" data-bs-toggle="modal"
                           data-bs-target="#Modaldetail-{{ $dt->id_komposisi_nilai }}"><span data-feather="edit"></span>
                        </a>
                </td>
            </tr>
            @endforeach
            <tr>
                <td class="text-center" colspan="2"> Total : </td>
                <td class="{{ $jumlah < 100 ? "bg-warning" : "bg-success" }}"> {{ $jumlah }} % </td>
            </tr>
        </tbody>
</table>
</div>

<!-- Modal -->
@foreach ($data as $dt )
<div class="modal fade" id="Modaldetail-{{ $dt->id_komposisi_nilai }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Edit Komponen {{ $dt->nama_komponen }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form action="/masterdata/storekomposisinilai" method="post">
            @csrf
        <div class="modal-body">
            <input type="hidden" name="id_komposisi_nilai" value="{{ $dt->id_komposisi_nilai }}">
            <input class="form-control" type="number" name="nilai_komponen" value="{{ $dt->nilai_komponen }}" max="100">
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-success">Simpan Perubahan</button>
        </form>
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




