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
                        <h4 class="card-label float-start">Daftar Ujian Menunggu Validasi</h4> <a class="btn btn-success float-end " href="/praktikan/createujian" role="button">Buat Ujian</a>

                    </div>

                </div>

                    <div class="col-xl-2"></div>

                    <div class="row">
                        <div class="table-responsive">
                            <table id="dtM" class="table table-bordered table-striped table-hover dataTable" style="font-size:12px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Kelas</th>
                                        <th>Jenis Ujian</th>
                                        <th>Status Ujian</th>
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
                                    @foreach ($data as $dt )
                                    <tr>

                                        <td>{{ $loop->iteration  }}</td>
                                        <td>{{ $dt->praktikum->kelas->nama_kelas }}</td>
                                        <td>{{ $dt->jenis_ujian }}</td>
                                        @if ($dt->is_validated == 'N')
                                            <td>Belum Divalidasi</td>
                                        @else
                                            <td>Sudah Divalidasi</td>
                                        @endif

                                        <td>
                                            <a href="#" class="badge bg-success" data-bs-toggle="modal" data-bs-target="#Modaldetail-{{ $dt->id_ujian }}"><span data-feather="eye"></span></a>
                                            <a href="#" class="badge bg-info"><span data-feather="edit"></span></a>
                                            @if ($dt->is_validated !='Sudah divalidasi')
                                            <a href="/praktikan/validasiujian/{{ $dt->id_ujian }}" class="badge bg-warning"><span data-feather="check-circle"></span></a>
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
@foreach ($data as $dt )

<div class="modal fade" id="Modaldetail-{{ $dt->id_ujian }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Uraian Ujian {{ $dt->jenis_ujian }} {{ $dt->praktikum->kelas->nama_kelas }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p><td>{!! $dt->uraian_ujian !!}</td></p>
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
