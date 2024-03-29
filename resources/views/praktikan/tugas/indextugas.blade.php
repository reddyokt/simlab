@extends('dashboard.layouts.main')

@section('page-style')
<link href="/css/datatables.bundle.css" rel="stylesheet" type="text/css" />
@stop

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
<link rel="stylesheet" type="text/css" href="/css/trix.css">
<script type="text/javascript" src="/js/trix.js"></script>


@section('container')
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Form-->
        <div class="alert mt-3">
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
        </div>

            <!--begin::Card-->
            <div class="card card-custom card-sticky mt-4" id="kt_page_sticky_card">
                <div class="card-header">
                    <div class="card-title">
                        <h4 class="card-label float-start">Daftar Tugas</h4>
                        <a class="btn btn-sm btn-success float-end " href="/praktikan/createtugas" role="button">Buat Tugas</a>
                        <div class="col-md-2 float-end">
                            <form action="/export/tugas" target="_blank" method="post">
                                @csrf
                                <button class="btn btn-sm btn-primary" role="button"><i class="fa fa-file-pdf-o"></i> export Tugas</button>
                            </form>
                        </div>
                    </div>

                </div>

                    <div class="col-xl-2"></div>

                    <div class="row">
                        <div class="table-responsive">
                            <table id="dtM" class="table table-bordered table-striped table-hover dataTable" style="font-size:12px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Modul</th>
                                        <th>Jenis Tugas</th>
                                        <th>Status Tugas</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $dt )
                                    <tr>

                                        <td>{{ $loop->iteration  }}</td>
                                        <td>{{ $dt->modul->praktikum->kelas->nama_kelas }} | {{ $dt->modul->nama_modul }}</td>
                                        <td>{{ $dt->jenis_tugas }}</td>
                                        @if ($dt->is_validated == 'N')
                                            <td>Belum Divalidasi</td>
                                            @else
                                            <td>Sudah Divalidasi</td>
                                        @endif

                                        <td>
                                            <a href="#" class="badge bg-success" data-bs-toggle="modal" data-bs-target="#Modaldetail-{{ $dt->id_tugas }}">
                                            <span data-feather="eye"></span></a>
                                            <a href="/praktikan/edittugas/{{ $dt->id_tugas }}" class="badge bg-info"><span data-feather="edit"></span></a>
                                            @if ($dt->is_validated !='N')
                                                @if ($dt->is_active =='N')
                                                <a href="/praktikan/showtugas/{{ $dt->id_tugas }}" class="badge bg-warning" onclick="return confirm('Yakin akan mengirimkan Tugas ini kepada Mahasiswa?!!!')">
                                                    <span data-feather="sunrise"></span></a>
                                                    @else
                                                    <a href="/praktikan/hidetugas/{{ $dt->id_tugas }}" class="badge bg-danger" onclick="return confirm('Yakin akan menyembunyikan Tugas ini?!!!')">
                                                    <span data-feather="sunset"></span></a>
                                                @endif
                                            @endif
                                            <a href="/praktikan/deletetugas/{{ $dt->id_tugas }}" class="badge bg-danger" onclick="return confirm('Yakin akan menghapus data Tugas?!!!')"><span data-feather="x-circle"></span></a>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            <div class="container mt-5">
                <div class="row">
                    <h5>Keterangan</h5>
                    <div class="col-2">
                        <p> <button class="badge bg-success"><span data-feather="eye"></span></button> Lihat Tugas </p>
                    </div>
                    <div class="col-2">
                        <p> <button class="badge bg-info"><span data-feather="edit"></span></button> Edit Tugas</p>
                    </div>
                    <div class="col-2">
                        <p> <button class="badge bg-warning"><span data-feather="sunrise"></span></button> Launching Tugas</p>
                    </div>
                    <div class="col-2">
                        <p> <button class="badge bg-danger"><span data-feather="sunset"></span></button> Hide Tugas</p>
                    </div>
                    <div class="col-2">
                        <p> <button class="badge bg-danger"><span data-feather="x-circle"></span></button> Delete Tugas</p>
                    </div>
                </div>
            </div>
            </div>

            <!--end::Card-->

        <!--end::Form-->
    </div>
    <!-- Modal -->
@foreach ($data as $dt )
<div class="modal fade" id="Modaldetail-{{ $dt->id_tugas }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Uraian Tugas {{ $dt->jenis_tugas }} {{ $dt->nama_modul }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p><td>{!! $dt->uraian_tugas !!}</td></p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
@endforeach
@stop

@section('page-script')
<script src="/js/datatables.bundle.js"></script>
<script src="/js/creategroupmanual.js"></script>

@stop
