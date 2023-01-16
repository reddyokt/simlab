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
                        <h4 class="card-label float-start">Buat Soal Ujian Akhir</h4>
                    </div>

                </div>
            <form id="tugas" action="/praktikan/createujian" method="POST">
                @csrf
                <div class="row">
                    <div class="col-xl-2"></div>
                    <div class="col-xl-8">
                        <div class="my-5">
                            <div class="form-group row mb-1">
                                <label class="col-3">Nama Kelas :</label>
                                <div class="col-9">
                                    <select class="form-control" name="praktikum_id" required>
                                        <option selected disabled>Pilih Kelas</option>
                                        @foreach ($praktikum as $prak)
                                         <option value="{{ $prak->id_praktikum }}">{{ $prak->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row mb-3">
                                <label class="col-3">Uraian Ujian :</label>
                                <div class="col-9">
                                    <input class="form-control" id="uraian_ujian" type="hidden" name="uraian_ujian" required>
                                    <trix-editor   input="uraian_ujian"></trix-editor>
                                </div>
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



