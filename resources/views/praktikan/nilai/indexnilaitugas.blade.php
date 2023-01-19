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
        @if (session()-> has('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        @endif
            <!--begin::Card-->
            <div class="card card-custom card-sticky mt-5" id="kt_page_sticky_card">
                <div class="card-header">
                    <div class="card-title">
                        <h4 class="card-label float-start">Daftar Praktikan Upload Jawaban</h4>

                    </div>

                </div>

                    <div class="col-xl-2"></div>

                    <div class="row">
                        <div class="table-responsive">
                            <table id="dtM" class="table table-bordered table-striped table-hover dataTable" style="font-size:12px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Kelas | Modul</th>
                                        <th>Jenis Tugas</th>
                                        <th>Nilai Tugas</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $dt )
                                    <tr>

                                        <td>{{ $loop->iteration  }}</td>
                                        <td>{{ $dt->mahasiswa->nama_mahasiswa}}</td>
                                        <td>{{ $dt->tugas->modul->praktikum->kelas->nama_kelas}} | {{ $dt->tugas->modul->nama_modul}}</td>
                                        <td>{{ $dt->tugas->jenis_tugas }}</td>
                                        @if ($dt->nilaitugas !==Null)
                                        <td>{{ $dt->nilaitugas }}</td>
                                        @else
                                        <td>Belum dinilai</td>
                                        @endif
                                        <td>
                                            <a href="{{URL($dt->file_jawaban)}}" target="_blank" class="badge bg-info"><span data-feather="download"></span></a>
                                            <a href="#" class="badge bg-danger"><span data-feather="edit" data-bs-toggle="modal" data-bs-target="#Modaldetail-{{ $dt->id_jawaban_tugas }}"></span></a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
    </div>
    <!-- Modal -->
                @foreach ($data as $dt )
                <div class="modal fade" id="Modaldetail-{{ $dt->id_jawaban_tugas }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> Isi Nilai </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/praktikan/isinilaitugas" method="post">
                            @csrf
                        <div class="modal-body">
                            <table id="dtM" class="table table-bordered table-striped table-hover dataTable" style="font-size:12px;">
                                <thead>
                                    <tr>
                                        <th>Nama Mahasiswa</th>
                                        <th>Isi Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <input type="hidden" name="id_jawaban_tugas" value="{{ $dt->id_jawaban_tugas }}">
                                        <td>{{ $dt->mahasiswa->nama_mahasiswa}}</td>
                                        <td><input type="text" name="nilaitugas" id="nilaitugas"> </td>
                                </tbody>
                            </table>
                        </div>
                        <div class="modal-footer">
                        <button  type="submit"  class="btn btn-success" >Simpan Nilai</button>
                        </div>
                        </form>
                    </div>
                    </div>
                </div>
                @endforeach
@stop

@section('page-script')
<script src="/js/datatables.bundle.js"></script>
<script src="/js/creategroupmanual.js"></script>

@stop
