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


    <!-- START CTA -->
    <section class="section bg-cta" id="cta">
        <div class="bg-overlay-3"></div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="cta-content text-white text-center">

                        <div class="text-white">
                            <h2 class="title">Daftar Kelas Praktikum</h2>
                            <div class="mt-5">
                                <a href="/daftarPraktikum" class="btn btn-primary">Klik Disini</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END CTA -->

        <!-- START JADWAL -->
        <section class="section bg-cta" id="jadwal">
            <div class="bg-overlay-3"></div>

            <div class="container d-block mx-auto align-item-center"">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="cta-content text-white text-center">
                        @if(count($jadwal)>0)
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
                                              </tr>
                                            </thead>
                                            <tbody>
                                            @foreach ($jadwal as $key=>$value)
                                              <tr>
                                                <th>{{ $loop->iteration  }} </th>
                                                <td>{{$value->nama_kelas}}</td>
                                                <td>{{$value->nama_modul}}</td>
                                                <td>{{ \Carbon\Carbon::parse($value->tanggal_praktek)->isoFormat('Do MMMM YYYY')}}</td>
                                                <td>{{ $value->nama_dosen}}</td>
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

        <!-- START SCREENSHOT
        <section class="section" id="screenshot">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="text-center title-content">
                            <h6 class="text-uppercase f-14 text-primary">screenshots </h6>
                            <h2 class="mt-3">Get Awesome Features,Without<br>Extra Charges</h2>
                            <p class="text-muted mt-3">Tempus porta massa sed eleifend sagittis eget aliquam iaculis enim.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="row mt-5">
                    <div class="col-lg-12 swiper-container pb-5">
                        <div class="swiper-wrapper">

                            <div class="item mt-4">

                            </div>


                            <div class="swiper-slide mt-4">
                                <a class="mfp-image" href="images/screenshot/screenshot-1.jpg" title="">
                                    <img src="images/screenshot/screenshot-1.jpg" class="img-fluid box-shadow-lg" alt="">
                                </a>
                            </div>

                            <div class="swiper-slide mt-4">
                                <a class="mfp-image" href="images/screenshot/screenshot-2.jpg" title="">
                                    <img src="images/screenshot/screenshot-2.jpg" class="img-fluid box-shadow-lg" alt="">
                                </a>
                            </div>

                            <div class="swiper-slide mt-4">
                                <a class="mfp-image" href="images/screenshot/screenshot-3.jpg" title="">
                                    <img src="images/screenshot/screenshot-3.jpg" class="img-fluid box-shadow-lg" alt="">
                                </a>
                            </div>

                            <div class="swiper-slide mt-4">
                                <a class="mfp-image" href="images/screenshot/screenshot-4.jpg" title="">
                                    <img src="images/screenshot/screenshot-4.jpg" class="img-fluid box-shadow-lg" alt="">
                                </a>
                            </div>

                            <div class="swiper-slide mt-4">
                                <a class="mfp-image" href="images/screenshot/screenshot-5.jpg" title="">
                                    <img src="images/screenshot/screenshot-5.jpg" class="img-fluid box-shadow-lg" alt="">
                                </a>
                            </div>

                            <div class="swiper-slide mt-4">
                                <a class="mfp-image" href="images/screenshot/screenshot-6.jpg" title="">
                                    <img src="images/screenshot/screenshot-6.jpg" class="img-fluid box-shadow-lg" alt="">
                                </a>
                            </div>

                            <div class="swiper-slide mt-4">
                                <a class="mfp-image" href="images/screenshot/screenshot-7.jpg" title="">
                                    <img src="images/screenshot/screenshot-7.jpg" class="img-fluid box-shadow-lg" alt="">
                                </a>
                            </div>
                        </div>

                        Add Arrows
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
        END SREENSHORT -->


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
