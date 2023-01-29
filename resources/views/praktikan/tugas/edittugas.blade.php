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
        <div class="card-body">

            <div class="card card-custom card-sticky mt-5" id="kt_page_sticky_card">
                <div class="card-header">
                    <div class="card-title">
                        <h4 class="card-label float-start">Ubah Tugas</h4>
                    </div>

                </div>
            <form id="tugas" action="/praktikan/edittugas/{{ $showtugas->id_tugas }}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-xl-2"></div>
                    <div class="col-xl-8">
                        <div class="my-5">
                            <div class="form-group row mb-2">
                                <label class="col-3">Nama Kelas :</label>
                                <div class="col-9">
                                <input type="text" name="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror"
                                id="nama_kelas" placeholder="Nama Kelas" required value="{{ $showtugas->modul->praktikum->kelas->nama_kelas }} - {{ $showtugas->modul->nama_modul }}" disabled >
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                    <label class="col-3">Jenis Tugas :</label>
                                    <div class="col-9">
                                        <select class="form-control" name="jenis_tugas" required>
                                            <option selected disabled>{{ $showtugas->jenis_tugas }} </option>
                                            <option value="Pre Test">Pre Test</option>
                                            <option value="Post Test">Post Test</option>
                                            <option value="Laporan">Laporan</option>
                                        </select>
                                    </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3">Uraian Tugas :</label>
                                <div class="col-9">
                                    <input class="form-control" id="uraian_tugas" type="hidden" name="uraian_tugas" value="{{ $showtugas->uraian_tugas }}" required>
                                    <trix-editor   input="uraian_tugas"></trix-editor>
                                </div>
                            </div>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button class="btn btn-primary" type="submit">Ubah Tugas</button>
                            </div>
                            </div>
                        </div>
                </div>
            </form>
        </div>


@stop

@section('page-script')
<script src="/js/datatables.bundle.js"></script>
<script src="/js/creategroupmanual.js"></script>

@stop



