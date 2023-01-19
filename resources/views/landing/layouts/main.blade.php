<!DOCTYPE html>

<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>SIMLAB</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Premium Bootstrap 4 Landing Page Template" />
    <meta name="keywords" content="bootstrap 4, premium, marketing, multipurpose" />
    <meta content="Themesbrand" name="author" />
    <!-- favicon -->
    <link rel="shortcut icon" href="images/favicon.ico">
    <!-- css -->
    <link href="/landing/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <link href="/landing/css/materialdesignicons.min.css" rel="stylesheet" type="text/css" />

    <!-- magnific pop-up -->
    <link rel="stylesheet" type="text/css" href="css/magnific-popup.css" />

    <!-- Swiper CSS -->
    <link rel="stylesheet" href="css/swiper.min.css">

    <!--Slider-->
    <link rel="stylesheet" type="text/css" href="/landing/css/owl.carousel.css" />
    <link rel="stylesheet" type="text/css" href="/landing/css/owl.theme.css" />
    <link rel="stylesheet" type="text/css" href="/landing/css/owl.transitions.css" />
    <link href="/landing/css/style.css" rel="stylesheet" type="text/css" />

</head>

<body>
    @include('landing.layouts.header')
    <!-- END HOME -->
    <section class="bg-home" id="home" >
        <div class="bg-overlay"></div>
        <div class="home-center">
            <div class="home-desc-center">
                <div class="container slidero" style="height:450px;>
                    <div class="row align-items-center">
                        <div class="col-lg-10 my-5">
                            <div class="home-content text-white ">
                                <h2 class="home-title ">SISTEM INFORMASI <br> MANAJEMEN LAB

                                </h2>
                                <h4 class="text-white f-29">
                                    PROGRAM STUDI <br>TEKNIK KIMIA<br>FAKULTAS TEKNIK
                                </h4>
                                <h5 class="text-white f-15">UNIVERSITAS MUHAMMADIYAH JAKARTA</h5>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="home-img">
                                <img src="images/home-img.png" class="img-fluid" alt="">
                            </div>
                        </div>
                    </div>

                </div>

            </div>
        </div>
    </section>
    <!-- END HOME -->
    <!-- START JADWAL -->
    <section class="section bg-cta" id="jadwal">
        <div class="bg-overlay-3"></div>

        <div class="container d-block mx-auto align-item-center"">
            <div class="row">
                <div class="col-lg-12">
                    <div class="cta-content text-white text-center">
                    @if(count($data)>0)
                    <div class="text-center text-white">
                        <h2 class="title">Daftar Jadwal Praktikum</h2>
                            <div class="card text-dark">
                                <div class="card-body">
                                    <table class="table">
                                        <thead>
                                          <tr>
                                            <th scope="col">#</th>
                                            <th scope="col">Nama Kelas</th>
                                            <th scope="col">Nama Modul</th>
                                            <th scope="col">Tanggal Praktek</th>
                                            <th scope="col">Dosen Pengampu</th>
                                            <th scope="col">Action</th>
                                          </tr>
                                        </thead>
                                        <tbody>
                                        @foreach ($data as $d)
                                          <tr>
                                            <th>{{ $loop->iteration  }} </th>
                                            <td>{{$d->praktikum->kelas->nama_kelas}}</td>
                                            <td>{{$d->nama_modul}}</td>
                                            <td>{{ \Carbon\Carbon::parse($d->tanggal_praktek)->isoFormat('Do MMMM YYYY')}}</td>
                                            <td>{{ $d->praktikum->dosen->nama_dosen}}</td>
                                            <td><a href="#" class="badge bg-success"
                                                data-bs-toggle="modal" data-bs-target="#Modaldetail-{{ $d->id_tugas }}"><i class="fa fa-eye"></i></a>
                                                <a href="#" class="badge bg-danger"
                                                data-bs-toggle="modal" data-bs-target="#Modaldetail2-{{ $d->id_tugas }}"><i class="fa fa-upload"></i></a>
                                            </td>
                                          </tr>
                                        @endforeach
                                        </tbody>
                                      </table>
                                </div>
                            </div>
                    </div>
                    @else
                    <div class="card">
                        <h5 class="text-center text-dark">Belum ada Jadwal Praktek tersedia</h5>
                    </div>
                    @endif
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END CTA -->

    <!-- START CTA -->
    <!--<section class="section bg-cta" id="cta">
        <div class="bg-overlay-3"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="cta-content text-white text-center">

                        <div class="text-white">
                            <h2 class="title">Pengumuman</h2>
                            <div class="mt-2">
                                <a href="/daftarPraktikum" class="btn btn-primary">Klik Disini</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>-->
    <!-- END CTA -->
        <!--START SCREENSHOT-->
        <section class="section bg-cta" id="pengumuman">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center title-content">
                            <h1 class="text-white mb-5">PENGUMUMAN</h1>
                            <div class="row">
                                @foreach ( $pengumuman as $p)
                                <div class="col-sm-6">
                                    <div class="card mb-3">
                                        <img src="{{URL($p->image)}}" class="card-img-top" alt="...">
                                        <div class="card-body">
                                        <h5 class="card-title">{{ $p->judul_pengumuman }}</h5>
                                        <p class="card-text text-justify">{!!$p->uraian_pengumuman !!}</p>
                                        <p class="card-text"><small class="text-muted">{{ \Carbon\Carbon::parse($p->created_at)->isoFormat('Do MMMM YYYY' )}}</small></p>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row mt-1">
                    <div class="col-lg-12 swiper-container ">
                        <div class="swiper-wrapper">

                        </div>

                        <div class="swiper-button-next">
                            <img src="images/arrow-right.png" class="img-fluid" alt="">
                        </div>
                        <div class="swiper-button-prev ">
                            <img src="images/arrow-left.png" class="img-fluid" alt="">
                        </div>

                    </div>
                </div>
            </div>
        </section>

        <section class="section bg-cta" id="download">
            <div class="bg-overlay-3"></div>
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="cta-content text-white text-center">

                            <div class="text-dark" style="font-weight:100;">
                                <h2 class="title text-white">Download</h2>
                                <div class="mt-4">
                                    <div class="container d-block mx-auto align-item-center">
                                        <div class="row">
                                            @foreach ( $download as $d)
                                            <div class="col-sm-3">
                                                <div class="card mb-3">
                                                    <img src="{{asset('img/pdf.png')}}" class="card-img-top mx-auto d-block mt-1" alt="..." style="width:60%">
                                                    <div class="card-body">
                                                    {{--<h5 class="card-title">{{ $d->judul_file }}</h5>--}}
                                                    <a href="{{ $d->pdf }}" target="_blank"> <p class="card-text">{!!$d->uraian_file !!}</p></a>
                                                    <p class="card-text"><small class="text-muted">{{ \Carbon\Carbon::parse($d->created_at)->isoFormat('Do MMMM YYYY' )}}</small></p>
                                                    </div>
                                                </div>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>


    <!-- START FOOTER -->
    <section class="section bg-footer py-5">
        <div class="bg-overlay-1"></div>

        <div class="container">
            <div class="row">
                <div class="col-lg-4">
                    <div class="footer-info mt-4">
                        <img src="images/logo-light.png" alt="" height="22">

                        <p class="text-white-50 mt-4 f-15">Program Studi Teknik Kimia, Fakultas Teknik UMJ <br>  Jl. Cempaka Putih2 Tengah No.27, Jakarta </p>
                        <p class="text-white f-20">(021) 425 6024</p>

                    </div>

                </div>

                <div class="col-lg-5 offset-lg-1">
                    <div class="mt-4">
                        <h5 class="text-white f-17">Pranala</h5>
                        <ul class="list-unstyled footer-link mt-3">
                            <li><a href="https://umj.ac.id/" target="_blank">umj.ac.id</a></a></li>
                            <li><a href="https://ft.umj.ac.id/ftumj/Halaman-Utama.html" target="_blank">ft.umj.ac.id</a></li>
                            <li><a href="https://tekim.umj.ac.id/" target="_blank">tekim.umj.ac.id</a></li>
                            <li><a href="https://magister-kimia.umj.ac.id/" target="_blank">magister-kimia.umj.ac.id</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2">
                    <div class="mt-4">
                        <h5 class="text-white f-17">Layanan</h5>
                        <ul class="list-unstyled footer-link mt-3">
                            <li><a href="https://siakad.umj.ac.id/gate/login" target="_blank">Siakad</a></li>

                        </ul>
                    </div>
                </div>


            </div>

            <div class="row mt-3">
                <div class="col-12">
                    <div class="footer-alt">

                        <div class="footer-info">
                            <p class="text-white-50">2021 © 2017470104</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END FOOTER -->

    <!-- Modal1 -->
    @foreach ( $data as $dt )

    <div class="modal fade " id="Modaldetail-{{ $dt->id_tugas }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Kelas {{ $dt->praktikum->kelas->nama_kelas }} - Modul {{ $dt->nama_modul }} </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="dtM" class="table table-bordered table-striped table-hover dataTable">
                    <tr>
                        <td>Tanggal Praktek</td>
                        <td>{{ $dt->tanggal_praktek }} </td>
                    </tr>

                  @foreach ( $dt->tugas as $tugas )
                  @if ($tugas->is_active=='Y')
                    <tr>
                        <td>Jenis Tugas</td>
                        <td>{{ $tugas->jenis_tugas }} </td>
                    </tr>
                    <tr>
                        <td>Uraian Tugas</td>
                        <td>{!! $tugas->uraian_tugas !!} </td>
                    </tr>
                    @endif
                  @endforeach

                  @if ($dt->tugas->where('is_active', 'Y')->count()==0)
                  <tr> <td colspan="2" class="text-center">Tugas Belum Tersedia!</td></tr>
                  @endif
                </table>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    @endforeach

    <!-- Modal2 -->
    @foreach ( $data as $dt )
    <div class="modal fade " id="Modaldetail2-{{ $dt->id_tugas }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Kelas {{ $dt->nama_kelas }} - {{ $dt->nama_modul }} </h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <table id="dtM" class="table table-bordered table-striped table-hover dataTable">
                    @foreach ( $dt->tugas as $tugas)
                    <tr>
                        <td>Jenis Tugas</td>
                        <td>{{$tugas->jenis_tugas  }} </td>
                    </tr>
                    <tr>
                        <td>Tanggal Praktek</td>
                        <td>{{ $dt->tanggal_praktek }} </td>
                    </tr>

                </table>
                <form id="tugas" action="/praktikan/uploadjawabantugas" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="row">
                        <div class="col-xl-2"></div>
                        <div class="col-xl-8">
                            <div class="my-5">
                                <div>
                                    <input type="hidden" name="tugas_id" value="{{ $tugas->id_tugas }}">
                                </div>
                                <div class="form-group row mb-1">
                                    <label class="col-4">NIM</label>
                                    <div class="col-8">
                                        <select class="form-control" name="mahasiswa_id" required>
                                            <option selected >Pilih NIM</option>
                                            @foreach ($tugas->modul->praktikum->mahasiswa as $mhs)
                                                <option value="{{ $mhs->id_mahasiswa }}">{{ $mhs->nim }} - {{ $mhs->nama_mahasiswa}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <!--<div class="form-group row mb-2">
                                        <label class="col-4">Masukkan Email</label>
                                        <div class="col-8">
                                            <input class="form-control" id="email" type="text" name="email" required>
                                        </div>
                                </div>-->
                                <div class="form-group row mb-2">
                                    <label class="col-4">Upload File Jawaban</label>
                                    <div class="col-8">
                                        <input accept="image/png, image/jpeg, image/jpg, application/pdf"
                                        class="form-control" type="file" id="file_jawaban" name="file_jawaban" placeholder="Hanya Menerima Image file (png,jpeg,jpg) dan PDF File">
                                        <p class="text-secondary"><small> Hanya Image file (png,jpeg,jpg) dan PDF File</small></p>
                                    </div>
                                </div>

                                <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                                    <button class="btn btn-primary" type="submit">Kirim Tugas</button>
                                </div>
                                </div>
                            </div>
                    </div>
                </form>
                @endforeach

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    @endforeach


    <!-- javascript -->
    <script src="/landing/js/jquery.min.js"></script>
    <script src="/landing/js/bootstrap.bundle.min.js"></script>
    <script src="/landing/js/jquery.easing.min.js"></script>
    <script src="/landing/js/scrollspy.min.js"></script>
    <!-- olw- carousel -->
    <script src="/landing/js/owl.carousel.min.js"></script>
    <!-- Magnific Popup -->
    <script src="/landing/js/jquery.magnific-popup.min.js"></script>
    <!-- swipper js -->
    <script src="/landing/js/swiper.min.js"></script>
    <!--Partical js-->
    <script src="/landing/js/particles.js"></script>
    <script src="/landing/js/particles.app.js"></script>
    <script src="/landing/js/jquery.mb.YTPlayer.js"></script>
    <!--flex slider plugin-->
    <script src="/landing/js/jquery.flexslider-min.js"></script>
    <!-- counter init -->
    <script src="/landing/js/counter.init.js"></script>
    <!-- contact init -->
    <script src="/landing/js/contact.init.js"></script>
    <script src="https://unicons.iconscout.com/release/v2.0.1/script/monochrome/bundle.js"></script>
    <script src="/landing/js/app.js"></script>



</body>

</html>
