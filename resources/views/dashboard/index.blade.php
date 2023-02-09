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
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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

            @if(auth()->user()->role_id =='5')
                @foreach ($praktikum as $p)
                    <div class="card mb-3 border-warning">
                        <div class="card-header">
                            <h5 class="text-center">Daftar Ujian {{$p->praktikum->nama_kelas }} - {{ $p->praktikum->kelas->nama_kelas }} </h5>
                        </div>
                        @foreach ( $p->praktikum->ujian as $uj)

                        @endforeach
                            <div class="row row-cols-1 row-cols-md-2 mb-2">
                                <div class="col">
                                    <div class="card">
                                        <div class="card-body">
                                        <h5 class="card-title text-center bg-secondary text-white"> Ujian Awal </h5>
                                            <div class="row">
                                                <div class="col-4">
                                                    <p> <a href="#" class="badge bg-warning" data-bs-toggle="modal"
                                                        data-bs-target="#Modaldetail7-{{ $uj->id_ujian }}"><span data-feather="eye"></span>
                                                    </a> Lihat Soal Ujian </p>
                                                </div>
                                                <div class="col-4">
                                                    <p> <button type="button" class="badge bg-info" data-bs-toggle="modal"
                                                        data-bs-target="#Modaldetail8-{{ $uj->id_ujian }}" ><span data-feather="edit"></span></button> Upload Jawaban</p>
                                                </div>

                                                <div class="col-4">
                                                    <p> <a href="/hapusjawabanujian/{{$uj->jawabanujian ? $uj->jawabanujian->id_jawaban_ujian : "" }}" class="badge bg-danger"><span data-feather="x-circle"></span>
                                                    </a> Hapus Jawaban</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col">
                                    <div class="card">
                                        <div class="card-body ">
                                        <h5 class="card-title text-center bg-secondary text-white">Ujian Akhir</h5>
                                        <div class="row">
                                            <div class="col-4">
                                                <p> <button class="badge bg-warning" data-bs-toggle="modal"
                                                    data-bs-target="#Modaldetail9-{{ $uj->id_ujian }}"><span data-feather="eye"></span></button> Lihat Soal Ujian </p>
                                            </div>
                                            <div class="col-4">
                                                <p> <button type="button"   class="badge bg-info" data-bs-toggle="modal"
                                                    data-bs-target="#Modaldetail10-{{ $uj->id_ujian }}"><span data-feather="edit"></span></button> Upload Jawaban</p>
                                            </div>
                                            <div class="col-4">
                                                <p> <a href="/hapusjawabanujian/{{$uj->jawabanujian ? $uj->jawabanujian->id_jawaban_ujian : "" }}" class="badge bg-danger"><span data-feather="x-circle"></span>
                                                </a> Hapus Jawaban</p>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                            </div>

                @endforeach
            @endif

            @if(auth()->user()->role_id =='5')
                    @foreach ($praktikum as $p)
                        <div class="card mb-3 border-primary">
                            <div class="card-header">
                                <h5 class="text-center"> Daftar Tugas {{$p->praktikum->nama_kelas }} - {{ $p->praktikum->kelas->nama_kelas }}</h5>
                            </div>

                            @foreach ($p->praktikum->modul  as $modul)
                                <h5 class="text-center"><small> {{ $modul->nama_modul }} </small></h5>
                                <div class="row row-cols-1 row-cols-md-3 ">
                                    <div class="col">
                                        <div class="card">
                                            <div class="card-body">
                                            <h5 class="card-title text-center bg-secondary text-white"> Pre Test </h5>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <p> <a href="#" class="badge bg-warning" data-bs-toggle="modal"
                                                            data-bs-target="#Modaldetail1-{{ $modul->id_modul }}"><span data-feather="eye"></span>
                                                        </a> Lihat Tugas </p>
                                                    </div>
                                                    <div class="col-6">
                                                        <p> <button type="button" {{ $modul->tugas->where('jenis_tugas', 'Pre Test')->where('is_active', 'N') ? "disabled" : "" }} class="badge bg-info" data-bs-toggle="modal"
                                                            data-bs-target="#Modaldetail4-{{ $modul->id_modul }}" ><span data-feather="edit"></span></button> Upload Jawaban</p>

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
                                                <p> <button class="badge bg-warning" data-bs-toggle="modal"
                                                    data-bs-target="#Modaldetail2-{{ $modul->id_modul }}"><span data-feather="eye"></span></button> Lihat Tugas </p>
                                            </div>
                                            <div class="col-6">
                                                <p> <button type="button" {{ $modul->tugas->where('jenis_tugas', 'Post Test')->where('is_active', 'N') ? "disabled" : "" }}  class="badge bg-info" data-bs-toggle="modal"
                                                    data-bs-target="#Modaldetail5-{{ $modul->id_modul }}"><span data-feather="edit"></span></button> Upload Jawaban</p>
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
                                                <p> <button class="badge bg-warning" data-bs-toggle="modal"
                                                    data-bs-target="#Modaldetail3-{{ $modul->id_modul }}"><span data-feather="eye"></span></button> Lihat Tugas </p>
                                            </div>
                                            <div class="col-6">

                                                <p> <button type="button" {{ $modul->tugas->where('jenis_tugas', 'Laporan')->where('is_active', 'N') ? "disabled" : "" }}  class="badge bg-info" data-bs-toggle="modal"
                                                    data-bs-target="#Modaldetail6-{{ $modul->id_modul }}"><span data-feather="edit"></span></button> Upload Jawaban</p>
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                                    </div>
                                </div>
                                <hr>
                            @endforeach
                        </div>
                    @endforeach
            @endif


<!-- Modal -->
            @foreach ($praktikum as $p )
                @foreach ($p->praktikum->modul  as $modul)
                <div class="modal fade" id="Modaldetail1-{{ $modul->id_modul }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tugas Pre Test</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            {!! $modul->tugas->where('jenis_tugas', 'Pre Test')->where('is_active', 'Y')->first() ? $modul->tugas->where('jenis_tugas', 'Pre Test')->first()->uraian_tugas : "belum ada tugas" !!}
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                    </div>
                </div>
                </div>

                <div class="modal fade" id="Modaldetail4-{{ $modul->id_modul }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Upload Jawabaan Tugas Pre Test</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/uploadjawaban" method="post" enctype="multipart/form-data">
                            @csrf
                        <div class="modal-body">
                            @if($modul->tugas->where('is_active', 'Y')->where('jenis_tugas', 'Pre Test')->count()==0)
                                <p> Tugas Belum Tersedia!</p>
                                @else
                            <input type="hidden" name="tugas_id" value="{{ $modul->tugas->where('is_active', 'Y')->where('jenis_tugas', 'Pre Test')->first() ? $modul->tugas->where('is_active', 'Y')->where('jenis_tugas', 'Pre Test')->first()->id_tugas : "" }}">
                            <input {{ $modul->tugas->where('is_active', 'N')->where('jenis_tugas', 'Post Test')->first() ? "disabled"  : "enable" }} accept="image/png, image/jpeg, image/jpg, application/pdf"
                            class="form-control" type="file" id="file_jawaban" name="file_jawaban"
                            placeholder="Hanya Menerima Image file (png,jpeg,jpg) dan PDF File">
                            @endif
                        <div class="modal-footer">
                            <button {{ $modul->tugas->where('is_active', 'N')->where('jenis_tugas', 'Post Test')->first() ? "disabled"  : "" }} type="submit" class="btn btn-success" data-bs-dismiss="modal">kirim jawaban</button>
                        </form>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                @endforeach
            @endforeach

            @foreach ($praktikum as $p )
                @foreach ($p->praktikum->modul  as $modul)
                <div class="modal fade" id="Modaldetail2-{{ $modul->id_modul }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tugas Post Test</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            {!! $modul->tugas->where('is_active', 'Y')->where('jenis_tugas', 'Post Test')->first() ? $modul->tugas->where('jenis_tugas', 'Post Test')->first()->uraian_tugas : "belum ada tugas" !!}
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                    </div>
                </div>
                </div>

                <div class="modal fade" id="Modaldetail5-{{ $modul->id_modul }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Upload Jawabaan Tugas Post Test</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/uploadjawaban" method="post" enctype="multipart/form-data">
                            @csrf
                        <div class="modal-body">
                            @if($modul->tugas->where('is_active', 'Y')->where('jenis_tugas', 'Post Test')->count()==0)
                                <p> Tugas Belum Tersedia!</p>
                                @else
                            <input type="hidden" name="tugas_id" value="{{ $modul->tugas->where('is_active', 'Y')->where('jenis_tugas', 'Post Test')->first() ? $modul->tugas->where('is_active', 'Y')->where('jenis_tugas', 'Post Test')->first()->id_tugas : "" }}">

                            <input {{ $modul->tugas->where('is_active', 'N')->where('jenis_tugas', 'Post Test')->first() ? "disabled"  : "enable" }} accept="image/png, image/jpeg, image/jpg, application/pdf"
                            class="form-control" type="file" id="file_jawaban" name="file_jawaban"
                            placeholder="Hanya Menerima Image file (png,jpeg,jpg) dan PDF File">
                            @endif
                        <div class="modal-footer">
                        <button {{ $modul->tugas->where('is_active', 'N')->where('jenis_tugas', 'Post Test')->first() ? "disabled"  : "" }} type="submit" class="btn btn-success" data-bs-dismiss="modal">kirim jawaban</button>
                        </form>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                @endforeach
            @endforeach

            @foreach ($praktikum as $p )
                @foreach ($p->praktikum->modul  as $modul)
                <div class="modal fade" id="Modaldetail3-{{ $modul->id_modul }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tugas Laporan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            {!! $modul->tugas->where('is_active', 'Y')->where('jenis_tugas', 'Laporan')->first() ? $modul->tugas->where('is_active', 'Y')->where('jenis_tugas', 'Laporan')->first()->uraian_tugas : "belum ada tugas" !!}
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        </div>
                    </div>
                    </div>
                </div>
                </div>

                <div class="modal fade" id="Modaldetail6-{{ $modul->id_modul }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Upload Jawabaan Laporan</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <form action="/uploadjawaban" method="post" enctype="multipart/form-data">
                            @csrf
                        <div class="modal-body">
                            @if($modul->tugas->where('is_active', 'Y')->where('jenis_tugas', 'Laporan')->count()==0)
                                <p> Tugas Belum Tersedia!</p>
                                @else
                            <input type="hidden" name="tugas_id" value="{{ $modul->tugas->where('is_active', 'Y')->where('jenis_tugas', 'Laporan')->first() ? $modul->tugas->where('is_active', 'Y')->where('jenis_tugas', 'Laporan')->first()->id_tugas : "" }}">
                            <input {{ $modul->tugas->where('is_active', 'N')->where('jenis_tugas', 'Post Test')->first() ? "disabled"  : "enable" }} accept="image/png, image/jpeg, image/jpg, application/pdf"
                            class="form-control" type="file" id="file_jawaban" name="file_jawaban"
                            placeholder="Hanya Menerima Image file (png,jpeg,jpg) dan PDF File" value="{{ $modul->tugas->where('is_active', 'Y')->where('jenis_tugas', 'Laporan')->first() ? $modul->tugas->where('is_active', 'Y')->where('jenis_tugas', 'Laporan')->first()->id_tugas : ""}}">
                            @endif
                        <div class="modal-footer">
                        <button {{ $modul->tugas->where('is_active', 'N')->where('jenis_tugas', 'Laporan')->first() ? "disabled"  : "" }} type="submit" class="btn btn-success" data-bs-dismiss="modal">kirim jawaban</button>
                        </form>
                        </div>
                    </div>
                    </div>
                </div>
                </div>
                @endforeach
            @endforeach

            @foreach ($praktikum as $p )
                    @foreach ( $p->praktikum->ujian as $uj)

                    <div class="modal fade" id="Modaldetail7-{{ $uj->id_ujian }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Soal Ujian Awal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @if($uj->is_active == 'N' and $uj->jenis_ujian == 'Ujian Awal')
                                    <p> Tugas Belum Tersedia!</p>
                                    @else
                                {!! $uj->uraian_ujian !!}
                                <br>
                                <a href="{{ URL($uj->soal_ujian) }}" target="_blank"><span data-feather="file"> </span> FILE UJIAN </a>
                                @endif
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>

                    <div class="modal fade" id="Modaldetail8-{{ $uj->id_ujian }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Upload Jawaban Ujian Awal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="/uploadjawabanujian" method="post" enctype="multipart/form-data">
                                @csrf
                            <div class="modal-body">
                                @if($uj->is_active == 'N')
                                    <p> Soal Belum Tersedia!</p>
                                    @else
                                <input type="hidden" name="ujian_id" value="{{ $uj->id_ujian }}">
                                <input accept="image/png, image/jpeg, image/jpg, application/pdf"
                                class="form-control" type="file" id="file_jawaban" name="file_jawaban"
                                {{-- @dd($uj->jawabanujian->toArray()) --}}
                                placeholder="Hanya Menerima Image file (png,jpeg,jpg) dan PDF File" value="">
                                @endif
                            <div class="modal-footer">
                            <button type="submit" class="btn btn-success" data-bs-dismiss="modal">kirim jawaban</button>
                            </form>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                    @endforeach
            @endforeach

            @foreach ($praktikum as $p )
                    @foreach ( $p->praktikum->ujian as $uj)

                    <div class="modal fade" id="Modaldetail9-{{ $uj->id_ujian }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Soal Ujian Awal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @if($uj->is_active == 'N' and $uj->jenis_ujian == 'Ujian Awal')
                                    <p> Soal Belum Tersedia!</p>
                                    @else
                                {!! $uj->uraian_ujian !!}
                                <br>
                                <a href="{{ URL($uj->soal_ujian) }}" target="_blank"><span data-feather="file"> </span> FILE UJIAN </a>
                                @endif
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>

                    <div class="modal fade" id="Modaldetail10-{{ $uj->id_ujian }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Upload Jawaban Ujian Awal</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <form action="/uploadjawabanujian" method="post" enctype="multipart/form-data">
                                @csrf
                            <div class="modal-body">
                                @if($uj->is_active == 'N')
                                    <p> Tugas Belum Tersedia!</p>
                                    @else
                                <input type="hidden" name="ujian_id" value="{{ $uj->id_ujian }}">
                                <input accept="image/png, image/jpeg, image/jpg, application/pdf"
                                class="form-control" type="file" id="file_jawaban" name="file_jawaban"
                                placeholder="Hanya Menerima Image file (png,jpeg,jpg) dan PDF File">
                                @endif
                            <div class="modal-footer">
                            <button type="submit" class="btn btn-success" data-bs-dismiss="modal">kirim jawaban</button>
                            </form>
                            </div>
                        </div>
                        </div>
                    </div>
                    </div>
                    @endforeach
            @endforeach

@endsection


