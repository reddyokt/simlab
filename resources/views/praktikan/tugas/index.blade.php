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
                        <h4 class="card-label">Daftar Tugas</h4>
                    </div>

                </div>
                <div class="card-body">
                <form id="tugas" action="/praktikan/createtugas" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-xl-2"></div>
                        <div class="col-xl-8">
                            <div class="my-5">
                                <div class="form-group row mb-1">
                                    <label class="col-3">Nama Modul :</label>
                                    <div class="col-9">
                                        <select class="form-control" name="id_modul" required>
                                            <option selected disabled>Pilih Modul</option>
                                            @foreach ($modul as $key=> $md )
                                             <option value="{{ $md->id_modul }}">{{ $md->nama_modul }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                        <label class="col-3">Jenis Tugas :</label>
                                        <div class="col-9">
                                            <select class="form-control" name="jenis_tugas" required>
                                                <option selected disabled>Pilih Jenis Test</option>
                                                <option value="Pre-Test">Pre Test</option>
                                                <option value='Post-Test'>Post Test</option>
                                            </select>
                                        </div>
                                </div>
                                <div class="form-group row mb-3">
                                    <label class="col-3">Uraian Tugas :</label>
                                    <div class="col-9">
                                        <input class="form-control" id="uraian_tugas" type="hidden" name="uraian_tugas" required>
                                        <trix-editor   input="uraian_tugas"></trix-editor>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button class="btn btn-primary" type="submit">Buat Tugas</button>
                                </div>
                                </div>
                            </div>
                    </div>
                    <div class="col-xl-2"></div>

                    <div class="row">
                        <div class="table-responsive">
                            <table id="dtM" class="table table-bordered table-striped table-hover dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Modul</th>
                                        <th>Jenis Tugas</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tugas as $tg )
                                    <tr>

                                        <td>{{ $loop->iteration  }}</td>
                                        <td>{{ $tg->nama_modul }}</td>
                                        <td>{{ $tg->jenis_tugas }}</td>
                                        <td>
                                            <a href="#" class="badge bg-success" data-bs-toggle="modal" data-bs-target="#Modaldetail-{{ $tg->id_tugas }}"><span data-feather="eye"></span></a>
                                            <a href="#" class="badge bg-info"><span data-feather="edit"></span></a>
                                            <a href="#" class="badge bg-danger"><span data-feather="x-circle"></span></a>
                                        </td>

                                    </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </form>
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
            <p><td>{!! $tg->uraian !!}</td></p>
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
