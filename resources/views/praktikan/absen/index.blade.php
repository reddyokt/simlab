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
                        <h4 class="card-label float-start">Isi Absen</h4>

                    </div>

                </div>

                    <div class="col-xl-2"></div>

                    <div class="row">
                        <div class="table-responsive">
                            <table id="dtM" class="table table-bordered table-striped table-hover dataTable">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Kelas</th>
                                        <th>Nama Modul</th>
                                        <th>Tanggal Praktek</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $dt )
                                    <tr>
                                        <td>{{ $loop->iteration  }}</td>
                                        <td>{{ $dt->praktikum->kelas->nama_kelas}}</td>
                                        <td>{{ $dt->nama_modul}}</td>
                                        <td>{{ $dt->tanggal_praktek}}</td>

                                        <td>
                                            <a href="#" class="badge bg-success" data-bs-toggle="modal" data-bs-target="#Modaldetail-{{$dt->id_modul}}"><span data-feather="eye"></span></a>
                                            <a href="#" class="badge bg-info"><span data-feather="edit"></span></a>
                                            <a href="#" class="badge bg-warning"><span data-feather="check-circle"></span></a>
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

    @foreach ( $data as $dt )
    @php
        $absen = App\Models\Absen::where('modul_id', $dt->id_modul)->get();

    @endphp
    <div class="modal fade" id="Modaldetail-{{$dt->id_modul}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">List Praktikan {{ $dt->praktikum->kelas->nama_kelas }} {{ $dt->nama_modul }}</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action='/praktikan/absen' method="post">
                    @csrf
                <table id="dtM" class="table table-bordered table-striped table-hover dataTable">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>NIM</th>
                            <th>Nama Mahasiswa</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <input type="hidden" value="{{ $dt->id_modul }}" name="modul_id">
                        @foreach ($dt->praktikum->mahasiswa as $mhs )
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $mhs->nim}}</td>
                            <td>{{ $mhs->nama_mahasiswa}}</td>
                            <td><input {{ $absen->contains('mahasiswa_id', $mhs->id_mahasiswa) ? "checked" : "" }} type="checkbox" name="mahasiswa_id[]" value="{{ $mhs->id_mahasiswa }}"></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div>
            <div class="modal-footer">
            <button class="btn btn-primary" data-bs-dismiss="modal">Simpan Absen?</button>
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
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
