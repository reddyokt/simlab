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
                        <h4 class="card-label float-start">Upload SOP/Modul</h4>
                    </div>

                </div>
            <form id="tugas" action="/download/create" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-xl-2"></div>
                    <div class="col-xl-8">
                        <div class="my-5">
                            <div class=" form-group row mb-1">
                                <div class="col-3">
                                    <label for="judul_file">Judul File :</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" name="judul_file" class="form-control @error('judul_file') is-invalid @enderror"
                                    id="judul_file" placeholder="Judul File" required value="{{ old ('judul_file') }}" >

                                    @error('judul_file')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3">Uraian File :</label>
                                <div class="col-9">
                                    <input class="form-control" id="uraian_file" type="hidden" name="uraian_file" required>
                                    <trix-editor   input="uraian_file"></trix-editor>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="pdf" class="col-3 form-label">Upload File (PDF)</label>
                                <div class="col-9">
                                    <input class="form-control" type="file" accept="application/pdf" id="pdf" name="pdf">
                                </div>
                              </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button class="btn btn-primary" type="submit">Upload File</button>
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



