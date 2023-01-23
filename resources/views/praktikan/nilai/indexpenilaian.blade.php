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
                        <h4 class="card-label float-start">Daftar Mahasiswa Modul</h4>

                    </div>

                </div>

                    <div class="col-xl-2"></div>
                    <div class="row">
                        <div class="table-responsive">
                            <table id="example" class="display" style="width:100%; font-size:12px">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Kelas</th>
                                        <th>Modul</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($data as $dt )
                                    <tr>
                                        <td>{{ $loop->iteration  }}</td>
                                        <td>{{ $dt->kelas->nama_kelas}} </td>
                                        <td>@foreach ( $dt->modul()->get() as $modul )
                                                <a href="#"><span data-bs-toggle="modal" data-bs-target="#Modaldetail-{{ $modul->id_modul }}">{{$modul->nama_modul}}</span></a> <br>
                                            @endforeach
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
                 @foreach ( $dt->modul()->get() as $modul)
                <div class="modal fade" id="Modaldetail-{{ $modul->id_modul }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel"> List Mahasiswa {{ $modul->nama_modul }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/praktikan/isinilaitugas" method="post">
                            @csrf
                        <div class="modal-body">
                            <table id="dtM" class="table table-bordered table-striped table-hover dataTable" style="font-size:12px;">
                                <thead>
                                    <tr>
                                        <th>Nama Mahasiswa</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <td>
                                    @foreach ( $modul->praktikum->mahasiswa()->get() as $mhs)
                                    <a href="{{ route('isinilai',['mahasiswa_id'=>$mhs->id_mahasiswa,
                                    'modul_id'=>$modul->id_modul]) }}">{{ $mhs->nama_mahasiswa }}</a><br>
                                    @endforeach
                                </td>

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
                @endforeach


@endsection
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
    $('#example').DataTable();
});</script>
