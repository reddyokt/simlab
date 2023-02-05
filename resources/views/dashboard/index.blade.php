@extends('dashboard.layouts.main')


@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Assalamu'alaikum {{ auth()->user()->nama_lengkap }}</h1>
</div>

@if (session()-> has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {!! session('success') !!}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error )
        <li> {{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

        @if (auth()->user()->role_id !='5')
          <div class="row  g-4">
            <div class="col">
              <div class="card h-100 border-success">
                <div class="card-body">
                {{-- @dd($data->toArray()) --}}
                  <h5 class="card-title">Periode Aktif - {{ $periode->tahun_ajaran }}</h5>
                  <p class="card-text">
                    @foreach ( $data as $dt )
                    Kelas Aktif : {{$dt->kelas->nama_kelas}} <br>
                    @endforeach
                  </p>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card h-100 border-warning">
                <div class="card-body">
                    <h5 class="card-title">Jumlah Mahasiswa Praktikum Aktif</h5>
                    <p class="card-text">{{ $datamhs }}</p>
                </div>
              </div>
            </div>
        @endif

        @if (auth()->user()->role_id =='5')
        <div class="row row-cols-1 row-cols-md-2 g-4 mb-5">
            <div class="col">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Absensi</h5>
                  <form action="/absensimhs" target="_blank" method="post">
                    @csrf
                    <select class="form-control mb-1" name="praktikum_id">
                        <option selected>Pilih Kelas Praktikum</option>
                        @foreach ( $data as $dt )
                        <option value="{{ $dt->id_praktikum }}">{{ $dt->nama_kelas }} {{ $dt->kelas->nama_kelas }} </option>
                        @endforeach
                    </select>
                    <button class="btn btn-sm btn-primary" type="submit">Lihat Data</button>
                    </form>
                </div>
              </div>
            </div>
            <div class="col">
              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Daftar Nilai</h5>
                  <form action="/nilaimhs" target="_blank" method="post">
                    @csrf
                    <select class="form-control mb-1" name="praktikum_id">
                        <option selected>Pilih Kelas Praktikum</option>
                        @foreach ( $data as $dt )
                        <option value="{{ $dt->id_praktikum }}">{{ $dt->nama_kelas }} - {{ $dt->kelas->nama_kelas }} </option>
                        @endforeach
                    </select>
                    <button class="btn btn-sm btn-primary" type="submit">Lihat Data</button>
                    </form>
                </div>
              </div>
            </div>
          </div>
          @endif

          @if (auth()->user()->role_id =='5')
            @foreach ( $tugas as $tg )
            @foreach ($tg->praktikum->modul as $modul )
            {{-- @dd($tg->praktikum->modul) --}}
            <div class="card mb-3 border-primary">
                <div class="card-header">
                    <h5 class="text-center">{{ $tg->praktikum->nama_kelas }} - {{ $tg->praktikum->kelas->nama_kelas }} - {{ $modul->nama_modul}}</h5>
                </div>
                <div class="card-body">
                    <div class="row row-cols-1 row-cols-md-3 g-4">
                        <div class="col">
                          <div class="card">
                            <div class="card-body">
                              <h5 class="card-title text-center bg-secondary text-white">Tugas Pre Test</h5>
                                <div class="row">
                                    <div class="col-6">
                                        <p> <a href="#" class="badge bg-warning" data-bs-toggle="modal"
                                            data-bs-target="#Modaldetail1-{{ $tg->id_tugas }}"><span data-feather="eye"></span>
                                         </a> Lihat Tugas </p>
                                    </div>
                                    <div class="col-6">
                                        <p> <button class="badge bg-info"><span data-feather="edit"></span></button> Upload Tugas</p>
                                    </div>
                                </div>
                            </div>
                          </div>
                        </div>

                        <div class="col">
                          <div class="card">
                            <div class="card-body">
                              <h5 class="card-title text-center bg-secondary text-white">Tugas Post Test</h5>
                              <div class="row">
                                <div class="col-6">
                                    <p> <button class="badge bg-warning"><span data-feather="eye"></span></button> Lihat Tugas </p>
                                </div>
                                <div class="col-6">
                                    <p> <button class="badge bg-info"><span data-feather="edit"></span></button> Upload Tugas</p>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col">
                          <div class="card">
                            <div class="card-body ">
                              <h5 class="card-title text-center bg-secondary text-white">Laporan</h5>
                              <div class="row">
                                <div class="col-6">
                                    <p> <button class="badge bg-warning"><span data-feather="eye"></span></button> Lihat Tugas </p>
                                </div>
                                <div class="col-6">
                                    <p> <button class="badge bg-info"><span data-feather="edit"></span></button> Upload Tugas</p>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
              </div>
              @endforeach
              @endforeach
              @endif


              <!-- Modal -->
{{-- @foreach ($tugas as $tg )

<div class="modal fade" id="Modaldetail1-{{ $tg->id_tugas }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLabel">Tugas Pre Test</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            {{ $tg->praktikum->modul->tugas->uraian_tugas }}
        <div class="modal-footer">
           <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  @endforeach --}}


@endsection


