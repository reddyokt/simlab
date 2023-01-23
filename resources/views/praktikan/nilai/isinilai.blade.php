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
                        <h4 class="card-label float-start">Nama Mahasiswa = {{ $mhs->nama_mahasiswa }} | Modul = {{ $mdl->nama_modul }}</h4>

                    </div>
                </div>
            </div>

            <div class="card mt-3" style="font-size:12px;">
                <div class="card-header bg-primary text-white">Isi Nilai Pretest</div>
                <div class="card-body">
                    <form action="/praktikan/isinilai1" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class=" form-group mb-1" style="font-size:12px;">

                        </div>
                        <div>
                            <input type="hidden" value="{{ $mhs_id }}" name="mahasiswa_id">
                            <input type="hidden" value="{{ $pretest->id_tugas }}" name="tugas_id">

                            @if ($jwbpretest)
                            <a href="{{URL($jwbpretest->file_jawaban) }}" target="_blank">File Jawaban</a>
                            @else
                            <p>Belum Upload Jawaban!</p>
                            @endif

                        </div>
                        <div class="form-group row mb-3" style="font-size:12px;">

                            <input type="text" name="nilai">

                        </div>
                        <button class="btn btn-sm btn-success float-start " role="button">Simpan</button>
                    </form>
                </div>
            </div>
            <div class="card mt-3" style="font-size:12px;">
                <div class="card-header bg-primary text-white">Isi Nilai Post Test</div>
                <div class="card-body">
                    <form action="/praktikan/isinilai1" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class=" form-group mb-1" style="font-size:12px;">

                        </div>
                        <div>

                            @if ($jwbposttest)
                            <a href="{{URL($jwbposttest->file_jawaban) }}" target="_blank">File Jawaban</a>
                            @else
                            <p>Belum Upload Jawaban!</p>
                            @endif

                        </div>
                        <div class="form-group row mb-3" style="font-size:12px;">

                            <input type="text" name="nilai">

                        </div>
                        <button class="btn btn-sm btn-success float-start " role="button">Simpan</button>
                    </form>
                </div>
            </div>
            <div class="card mt-3" style="font-size:12px;">
                <div class="card-header bg-primary text-white">Isi Nilai Laporan</div>
                <div class="card-body">
                    <form action="/praktikan/isinilai1" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class=" form-group mb-1" style="font-size:12px;">

                        </div>
                        <div>

                            @if ($jwblaporan)
                            <a href="{{URL($jwblaporan->file_jawaban) }}" target="_blank">File Jawaban</a>
                            @else
                            <p>Belum Upload Jawaban!</p>
                            @endif

                        </div>
                        <div class="form-group row mb-3" style="font-size:12px;">

                            <input type="text" name="nilai">

                        </div>
                        <button class="btn btn-sm btn-success float-start " role="button">Simpan</button>
                    </form>
                </div>
            </div>
            <div class="card mt-3" style="font-size:12px;">
                <div class="card-header bg-primary text-white">Isi Nilai Subjektif</div>
                <div class="card-body">
                    <form action="/praktikan/import" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class=" form-group mb-1" style="font-size:12px;">

                        </div>
                        <div>

                            <input type="hidden" value="{{ $mhs_id }}" name="mahasiswa_id">
                            <input type="hidden" value="{{ $modul_id }}" name="modul_id">

                        </div>
                        <div class="form-group row mb-3" style="font-size:12px;">

                            <input type="text" name="nilai_pretest">

                        </div>
                        <button class="btn btn-sm btn-success float-start " role="button">Simpan</button>
                    </form>
                </div>
            </div>





@endsection
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
    $('#example').DataTable();
});</script>
