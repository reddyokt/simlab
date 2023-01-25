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
                <div class="card-header d-flex justify-content-center bg-primary">
                    <div class="card-title text-white ">
                        <h5 class="card-label float-start">{{ $mdl->nama_modul }} - {{ $mhs->nama_mahasiswa }} - {{ $mhs->nim }}</h5>

                    </div>
                </div>
            </div>
        <form action="/praktikan/isinilai1" method="post">
            @csrf
            <div class="row d-flex justify-content-center">
                <div class="col-md-3">
                    <div class="card mt-3" style="width: 14rem;">
                        <div class="card-header bg-success text-white d-flex justify-content-center">
                            <h4>Isi Nilai Pretest</h4>
                          </div>
                        @if ($jwbpretest)
                        <a href="{{URL($jwbpretest->file_jawaban)}}" target="_blank"> <img class="card-img-top" src="{{asset('img/file.png')}}" alt="Card image cap"> </a>
                        @else
                        <a href="#" onclick="return false;"> <img class="card-img-top" src="{{asset('img/belum-upload.png')}}" alt="Belum Upload Jawaban"> </a>
                        @endif

                        <div class="card-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon1">Isi Nilai</span>
                                </div>
                                <input type="hidden" value="{{ $mhs_id }}" name="mahasiswa_id">
                                <input type="hidden" value="{{ $pretest->id_tugas }}" name="tugas_id">
                                <input type="text" name="nilai" class="form-control" placeholder="1-100" aria-label="1-100" aria-describedby="basic-addon1" >
                              </div>
                              <button role="button" class="btn btn-sm btn-warning">Simpan</button>
                        </div>
                      </div>
                </div>

                <div class="col-md-3">
                    <div class="card mt-3" style="width: 14rem;">
                        <div class="card-header bg-success text-white d-flex justify-content-center">
                            <h4>Isi Nilai Post Test</h4>
                          </div>
                        @if ($jwbposttest)
                        <a href="{{URL($jwbposttest->file_jawaban)}}" target="_blank"> <img class="card-img-top" src="{{asset('img/file.png')}}" alt="Card image cap"> </a>
                        @else
                        <a href="#" onclick="return false;"> <img class="card-img-top" src="{{asset('img/belum-upload.png')}}" alt="Belum Upload Jawaban"> </a>
                        @endif

                        <div class="card-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon1">Isi Nilai</span>
                                </div>
                                <input type="hidden" value="{{ $mhs_id }}" name="mahasiswa_id">
                                <input type="hidden" value="{{ $pretest->id_tugas }}" name="tugas_id">
                                <input type="text" class="form-control" placeholder="1-100" aria-label="1-100" aria-describedby="basic-addon1" name="nilai">
                              </div>
                              <button role="button" class="btn btn-sm btn-warning">Simpan</button>
                        </div>
                      </div>
                </div>

                <div class="col-md-3">
                    <div class="card mt-3" style="width: 14rem;">
                        <div class="card-header bg-success text-white d-flex justify-content-center">
                            <h4>Isi Nilai Laporan</h4>
                          </div>
                        @if ($jwblaporan)
                        <a href="{{URL($jwblaporan->file_jawaban)}}" target="_blank"> <img class="card-img-top" src="{{asset('img/file.png')}}" alt="Card image cap"> </a>
                        @else
                        <a href="#" onclick="return false;"> <img class="card-img-top" src="{{asset('img/belum-upload.png')}}" alt="Belum Upload Laporan"> </a>
                        @endif

                        <div class="card-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon1">Isi Nilai</span>
                                </div>
                                <input type="hidden" value="{{ $mhs_id }}" name="mahasiswa_id">
                                <input type="hidden" value="{{ $pretest->id_tugas }}" name="tugas_id">
                                <input type="text" class="form-control" placeholder="1-100" aria-label="1-100" aria-describedby="basic-addon1" name="nilai">
                              </div>
                              <button role="button" class="btn btn-sm btn-warning">Simpan</button>
                        </div>
                      </div>
                </div>

                <div class="col-md-3">
                    <div class="card mt-3" style="width: 14rem;">
                        <div class="card-header bg-success text-white d-flex justify-content-center">
                            <h4>Isi Nilai Subjektif</h4>
                          </div>
                              <a href="#" onclick="return false;"> <img class="card-img-top" src="{{asset('img/subjektif.png')}}" alt="Card image cap"> </a>
                        <div class="card-body">
                            <div class="input-group mb-3">
                                <div class="input-group-prepend">
                                  <span class="input-group-text" id="basic-addon1">Isi Nilai</span>
                                </div>
                                <input type="hidden" value="{{ $mhs_id }}" name="mahasiswa_id">
                                <input type="hidden" value="{{ $modul_id }}" name="modul_id">
                                <input type="text" class="form-control" placeholder="1-100" aria-label="1-100" aria-describedby="basic-addon1" name="nilai">
                              </div>
                              <button role="button" class="btn btn-sm btn-warning">Simpan</button>
                        </div>
                      </div>
                </div>
            </div>
        </form>

@endsection
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
    $('#example').DataTable();
});</script>
