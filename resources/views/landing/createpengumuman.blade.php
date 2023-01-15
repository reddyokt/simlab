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
                        <h4 class="card-label float-start">Buat Pengumuman</h4>
                    </div>

                </div>
            <form id="tugas" action="/pengumuman/create" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-xl-2"></div>
                    <div class="col-xl-8">
                        <div class="my-5">
                            <div class=" form-group row mb-1">
                                <div class="col-3">
                                    <label for="judul_pengumuman">Judul Pengumuman :</label>
                                </div>
                                <div class="col-9">
                                    <input type="text" name="judul_pengumuman" class="form-control @error('judul_pengumuman') is-invalid @enderror"
                                    id="judul_pengumuman" placeholder="Judul Pengumuman" required value="{{ old ('judul_pengumuman') }}" >

                                    @error('judul_pengumuman')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-3">Uraian Pengumuman :</label>
                                <div class="col-9">
                                    <input class="form-control" id="uraian_pengumuman" type="hidden" name="uraian_pengumuman" required>
                                    <trix-editor   input="uraian_pengumuman"></trix-editor>
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label for="image" class="col-3 form-label">Upload Foto /Gambar</label>
                                <div class="col-9">
                                    <input class="form-control" type="file" id="image" name="image">
                                </div>
                              </div>

                            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                <button class="btn btn-primary" type="submit">Buat Pengumuman</button>
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



