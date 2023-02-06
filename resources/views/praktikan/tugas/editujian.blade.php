@extends('dashboard.layouts.main')

@section('page-style')
<link href="/css/datatables.bundle.css" rel="stylesheet" type="text/css" />
@stop

<link rel="stylesheet" type="text/css" href="/css/trix.css">
<script type="text/javascript" src="/js/trix.js"></script>


@section('container')
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
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <div class="card-body">

            <div class="card card-custom card-sticky" id="kt_page_sticky_card">
                <div class="card-header">
                    <div class="card-title">
                        <h4 class="card-label float-start">Ubah Soal Ujian</h4>
                    </div>

                </div>
            <form id="tugas" action="/praktikan/editujian/{{ $showujian->id_ujian }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-xl-2"></div>
                    <div class="col-xl-8">
                        <div class="my-5">
                            <div class="form-group row mb-1">
                                <input type="hidden" name="praktikum_id" value="{{ $showujian->praktikum_id }}">
                                <label class="col-3">Nama Kelas :</label>
                                <div class="col-9">
                                    <select class="form-control" name="praktikum_id" required disabled>
                                        <option >{{ $showujian->praktikum->nama_kelas }} {{ $showujian->praktikum->kelas->nama_kelas }}</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-1">
                                <label class="col-3">Jenis Ujian :</label>
                                <div class="col-9">
                                    <select class="form-control" name="jenis_ujian" required>
                                        <option {{ $showujian->jenis_ujian == $showujian->praktikum_id ? "selected" : "" }} value="{{ $showujian->jenis_ujian }}">{{ $showujian->jenis_ujian }}</option>
                                         <option value="Ujian Awal">Ujian Awal</option>
                                         <option value="Ujian Akhir">Ujian Akhir</option>
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-3">Uraian Ujian :</label>
                                <div class="col-9">
                                    <input class="form-control" id="uraian_ujian" type="hidden" name="uraian_ujian" required>
                                    <trix-editor   input="uraian_ujian">{!! $showujian->uraian_ujian !!}</trix-editor>
                                </div>
                            </div>

                            <div class="form-group mb-3">
                                <label for="formFile" class="form-label" ><a href="{{ URL($showujian->soal_ujian) }}" target="_blank" class="badge bg-warning"><span data-feather="file-text"></span></a> << Soal Ujian diupload</label>
                                <input class="form-control" type="file" accept="application/pdf, image/png, image/jpeg, image/jpg" id="formFile" name="soal_ujian" >
                              </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button class="btn btn-primary" type="submit">Buat Ujian</button>
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



