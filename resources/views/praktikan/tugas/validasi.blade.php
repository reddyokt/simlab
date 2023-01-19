@extends('dashboard.layouts.main')

@section('page-style')
<link href="/css/datatables.bundle.css" rel="stylesheet" type="text/css" />
@stop

<link rel="stylesheet" type="text/css" href="/css/trix.css">
<script type="text/javascript" src="/js/trix.js"></script>


@section('container')
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Form-->

            <!--begin::Card-->
            <div class="card card-custom card-sticky mt-5" id="kt_page_sticky_card">
                <div class="card-header">
                    <div class="card-title">
                        <h4 class="card-label float-start">Daftar Tugas Menunggu Validasi</h4> <a class="btn btn-success float-end " href="/praktikan/createtugas" role="button">Buat Tugas</a>

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
                                @if (session()-> has('success'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                @endif
                                <tbody>
                                    @foreach ($tugas as $tg )
                                    <tr>

                                        <td>{{ $loop->iteration  }}</td>
                                        <td>{{ $tg->nama_modul }}</td>
                                        <td>{{ $tg->jenis_tugas }}</td>
                                        @if ($tg->is_validated == 'N')
                                            <td>Belum Divalidasi</td>
                                        @else
                                            <td>Sudah Divalidasi</td>
                                        @endif

                                        <td>
                                            <a href="#" class="badge bg-success" data-bs-toggle="modal" data-bs-target="#Modaldetail-{{ $tg->id_tugas }}"><span data-feather="eye"></span></a>
                                            <a href="#" class="badge bg-info"><span data-feather="edit"></span></a>
                                            @if ($tg->is_validated !='Sudah divalidasi')
                                            <a href="/praktikan/validasi/{{ $tg->id_tugas }}" class="badge bg-warning"><span data-feather="check-circle"></span></a>
                                            @endif
                                            <a href="#" class="badge bg-danger"><span data-feather="x-circle"></span></a>
                                        </td>

                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Card-->

        <!--end::Form-->
    </div>
    <!-- Modal -->
@foreach ($tugas as $tg )

<div class="modal fade" id="Modaldetail-{{ $tg->id_tugas }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Uraian Tugas {{ $tg->jenis_tugas }} {{ $tg->nama_modul }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p><td>{!! $tg->uraian_tugas !!}</td></p>
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
