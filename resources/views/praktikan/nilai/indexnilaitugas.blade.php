@extends('dashboard.layouts.main')

@section('page-style')
<link href="/css/datatables.bundle.css" rel="stylesheet" type="text/css" />
@stop
<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
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
                    <div class="row card-title">
                        <div class="col-md-6">
                            <h4 class=" card-label float-start">Daftar Praktikan Upload Jawaban Tugas dan Laporan</h4>
                        </div>
                        <div class="col-md-2">
                            <p> <i class="badge bg-danger col"> <span data-feather="download"></span></i> : File Pre Test</p>
                        </div>
                        <div class="col-md-2">
                            <p> <i class="badge bg-warning"> <span data-feather="download"></span></i> : File Post Test </p>
                        </div>
                        <div class="col-md-2">
                            <p> <i class="badge bg-success"> <span data-feather="download"></span></i> : File Laporan </p>
                        </div>
                    </div>
                </div>
                    <div class="col-xl-2"></div>
                    <div class="row">
                        <div class="card-body">
                            <table id="example1" class="display" style="width:100%; font-size:10px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Kelas | Modul</th>
                                        <th>Nilai Tugas Pre test</th>
                                        <th>Nilai Tugas Post test</th>
                                        <th>Nilai Laporan</th>
                                        <th>File Jawaban</th>
                                        <th>Input Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $dt )
                                    <tr>
                                        <td>{{ $loop->iteration  }}</td>
                                        <td>{{ $dt->mahasiswa->nama_mahasiswa}}</td>
                                        <td>{{ $dt->tugas->modul->praktikum->kelas->nama_kelas}} | {{ $dt->tugas->modul->nama_modul}}</td>
                                        @if ($dt->nilaitugas !==Null)
                                        <td>{{ $dt->nilaitugaspretest }}</td>
                                        @else
                                        <td>Belum dinilai</td>
                                        @endif

                                        @if ($dt->nilaitugas !==Null)
                                        <td>{{ $dt->nilaitugaspostest }}</td>
                                        @else
                                        <td>Belum dinilai</td>
                                        @endif

                                        @if ($dt->nilailaporan !==Null)
                                        <td>{{$td->nilailaporan}}</td>
                                        @else
                                        <td>Belum dinilai</td>
                                        @endif
                                        <td rowspan="3">
                                            <a href="{{URL($dt->file_jawaban)}}" target="_blank" class="badge bg-danger"><span data-feather="download"></span></a>
                                            <a href="{{URL($dt->file_jawaban)}}" target="_blank" class="badge bg-warning"><span data-feather="download"></span></a>
                                            <a href="{{URL('')}}" target="_blank" class="badge bg-success"><span data-feather="download"></span></a>
                                        </td>
                                        <td>
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
                                        <th>Jenis Tugas</th>
                                        <th>Isi Nilai</th>
                                    </tr>
                                </thead>
                                <tbody>
                                        <input type="hidden" name="id_jawaban_tugas" value="{{ $dt->id_jawaban_tugas }}">
                                        <td>{{ $dt->mahasiswa->nama_mahasiswa}}</td>
                                        <td></td>
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
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
    $('#example1').DataTable();
});</script>
<script type="text/javascript">
    $(document).ready(function () {
    $('#example2').DataTable();
});</script>
