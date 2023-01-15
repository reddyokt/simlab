@extends('dashboard.layouts.main')

@section('page-style')
<link href="/css/datatables.bundle.css" rel="stylesheet" type="text/css" />
@stop

@section('container')
<div class="d-flex flex-column-fluid">
    <!--begin::Container-->
    <div class="container">
        <!--begin::Form-->
        <form id="form_add_manual" action="/praktikan/createkelompok" method="POST">
            @csrf
            <!--begin::Card-->
            <div class="card card-custom card-sticky mt-5" id="kt_page_sticky_card">
                <div class="card-header">
                    <div class="card-title">
                        <h3 class="card-label">Pembentukan Kelompok
                    </div>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-xl-2"></div>
                        <div class="col-xl-8">
                            <div>
                               {{--   <div class="form-group row">
                                    <label class="col-3">Pilih Kelas</label>
                                    <div class="col-9">
                                        <select class="form-control" name="kelas_id" id="kelas_id" value="{{ old ('kelas_id') }}">
                                            <option selected disabled> Pilih Kelas</option>
                                            @foreach ( $dataMhs as $d)
                                            <option value="{{ $d->kelas->kelas_id }}">{{ $d->kelas->nama_kelas }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>--}}
                            </div>
                        </div>
                        <div class="col-xl-2"></div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-xl-2"></div>
                        <div class="col-xl-8">
                            <div >
                                <div class="form-group row">
                                    <label class="col-3">Nama Kelompok</label>
                                    <div class="col-9">
                                        <input type="text" required name="nama_kelompok" class="form-control" placeholder="Masukan Nama Kelompok">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-2"></div>
                    </div>

                    <div class="row mt-3">
                        <div class="table-responsive">
                            <table id="dtM" class="table table-bordered table-striped table-hover dataTable">
                                <thead>
                                    <tr>
                                        <th><input type="checkbox" name="select_all3" value="1" id="example-select-all3"></th>
                                        <th>NIM</th>
                                        <th>Nama</th>
                                        <th>Praktikum Dipilih</th>
                                    </tr>
                                </thead>
                                <tbody>
                                     @foreach($dataMhs as $value)
                                    <tr>
                                        <td><input type="checkbox" value="{{$value->mahasiswa_id.'-'.$value->praktikum_id}}" name="id_mahasiswa[]"></td>
                                        <td>{{$value->mahasiswa->nim}}</td>
                                        <td>{{$value->mahasiswa->nama_mahasiswa}}</td>
                                        <td>{{$value->praktikum->kelas->nama_kelas}}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <!--end::Card-->
            <button class="btn btn-lg btn-primary mx-auto d-block mt-2" type="submit">Buat Kelompok</button>
        </form>
        <!--end::Form-->
    </div>
@stop

@section('page-script')
<script src="/js/datatables.bundle.js"></script>
<script src="/js/creategroupmanual.js"></script>

@stop
