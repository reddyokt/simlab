@extends('dashboard.layouts.main')

@section('container')

<!-- Custom styles for this datatables -->
<link href="https://cdn.datatables.net/1.12.1/css/jquery.dataTables.min.css" rel="stylesheet">
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
                        <h4 class="card-label float-start">Daftar Nilai AKhir Mahasiswa</h4>
                    </div>
                </div>

                    <div class="col-xl-2"></div>
                    <form action="/export/nilaiakhir" target="_blank" method="POST">
                        @csrf
                        <div class="row p-3">
                            <div class="col">
                                <select class="form-select form-select-sm dflex" name="praktikum_id" aria-label="id_praktikum">
                                @foreach ($praktikum as $p )
                                    <option value="{{ $p->id_praktikum }}">{{ $p->kelas->nama_kelas }}</option>
                                @endforeach
                                </select>
                            </div>
                            <div class="col">
                                <button class="dflex btn btn-sm btn-primary" role="button">Export Nilai Akhir</button>
                            </div>
                        </div>
                    </form>

                    <div class="row">
                        <div class="table-responsive p-3">
                            <table id="example1" class="display " style="width:100%; font-size:12px;">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Kelas </th>
                                        <th>Nilai Akhir</th>
                                        {{-- <th>Action</th> --}}
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $dt )
                                    <tr>

                                        <td>{{ $loop->iteration  }}</td>
                                        <td>{{ $dt->mahasiswa->nama_mahasiswa}}</td>
                                        <td>{{ $dt->praktikum->kelas->nama_kelas}} </td>
                                        <td>{{ $dt->nilaiakhir }}</td>
                                        {{-- <td>
                                            <a href="#" class="badge bg-danger"><span data-feather="eye" data-bs-toggle="modal" data-bs-target="#Modaldetail-{{ $dt->id_praktikum_mahasiswa }}"></span></a>
                                        </td> --}}
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
                <div class="modal fade" id="Modaldetail-" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                                        <input type="hidden" name="mahasiswa_id" value="{{ $dt->mahasiswa->id_mahasiswa }}">
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
@endsection
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
    $('#example1').DataTable();
});</script>
