<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>SIMLAB | Daftar Praktikum</title>


    <script src="/daftar/js/plugins.min.js"></script>
    <script src="/daftar/js/app.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
  <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <!-- favicon CSS -->
    <link rel="icon" type="image/png" sizes="32x32" href="favicon.png">
    <!-- fonts -->
    <link href="/daftar/fonts/sfuidisplay.css" rel="stylesheet">
    <!-- Icon fonts -->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.1/css/all.css">
    <!-- Plugins CSS -->
    <link rel="stylesheet" href="/daftar/css/plugins.min.css">
    <!-- Style CSS -->
    <link rel="stylesheet" href="/daftar/css/app.css">
    <!-- Your CSS -->
</head>

<body class="theme-gradient-1" data-spy="scroll" data-target="#navbar-nav" data-animation="false" data-appearance="light">
    <!-- =========== Start of Loader ============ -->
    <div class="preloader">
        <div class="wrapper">
            <div class="blobs">
                <div class="blob-center"></div>
                <div class="blob"></div>
                <div class="blob"></div>
                <div class="blob"></div>
                <div class="blob"></div>
                <div class="blob"></div>
                <div class="blob"></div>
            </div>
            <div>
                <div class="loader-canvas canvas-left"></div>
                <div class="loader-canvas canvas-right"></div>
            </div>
        </div>
    </div>
    <!-- =========== End of Loader ============ -->

    <main class="main hidden">
        <!-- =========== Start of Navigation (main menu) ============ -->
        <header class="navbar navbar-expand-lg navbar-dark">
            <div class="container d-flex justify-content-center ">
                <a class="navbar-brand" href="index.html">
                    <img class="navbar-brand mx-auto d-block"  src="img/simlab-logo.png" style="width: 50%" alt="brand-logo">
                </a>
                <!--  End of brand logo -->

                <!-- end of nav CTA button -->
            </div>
            <!-- end of container -->
        </header>
        <!-- =========== End of Navigation (main menu)  ============ -->

        <!-- =========== Start of Body ============ -->
        <section class="space bg-color--primary h-min-50vh d-flex align-items-center">
            <div class="svg-shape--top w-100 opacity--05">
                <img src="img/layout/wave-8.svg" alt="wave" class="svg fill--white">
            </div>
            <!-- end of whole area svg bg -->
            <div class="svg-shape--top opacity--10">
                <img src="img/layout/wave-9.svg" alt="wave" class="svg fill--white">
            </div>
            <!-- end of top right mini svg shape -->

            <div class="container">
                <div class="row ">
                    <div class="col-12 mx-auto color--white text-center mb-4 mb-lg-1">
                        <h1 class="h2-font mb-1">Daftar Praktikum</h1>




                        @if (session()-> has('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                     @endif
                    </div>

                    <div class="col-10 col-sm-8 col-md-7 col-lg-6 col-xl-6 mx-auto">
                        <div class="form--v5 bg-color--primary-light--1 py-4 px-md-5 py-md-6 rounded--10">
                            <form action="/daftarPraktikum" method="post" class="form">
                                @csrf
                                <label>Cari Nim</label>
                                <div class="form-group row">
                                    <select class="nim col-md-4" id="select2" name="id_mahasiswa" type="text" required>
                                        @foreach ( $daftar as $key=> $da )
                                            <option value="{{ $da->id_mahasiswa }}" value="{{ $da->nama_mahasiswa }}"> {{ $da->nim }}</option>
                                        @endforeach
                                    </select>
                                    <input id="namamhs" type="text" class="namamhs col" name="namamhs" value="{{ old('namamhs') }}"/>
                                </div>

                                <!--<div class="form-group">
                                <select class="namamhs form-control">
                                    <option disabled="true" selected="true"></option>
                                </select>
                                </div>-->

                                <div class="form-group">
                                    <label class="form__label text-uppercase font-size--15 font-w--500 @error('email') is-invalid @enderror mx-1">Email Address:</label>
                                    <input id="email" type="email" class="form-control" name="email" placeholder="Enter your email address" required/>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                     @enderror
                                </div>
                                <div class="form-group">
                                    <label class="form__label text-uppercase font-size--15 font-w--500 mx-1">Phone Number:</label>
                                    <input id="phone" type="text" class="form-control" name="phone" placeholder="Enter your Phone Number" required/>
                                    @error('phone')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                     @enderror

                                </div>
                                <div class="form-group">
                                    <label class="form__label text-uppercase font-size--15 font-w--500 mx-1">Pilih Kelas</label>
                                    <select class="form-control p-1" id="id_kelas" name="id_kelas" type="text" >
                                    <option value="">Pilih Kelas</option>
                                        @foreach ( $kelas  as $kel )
                                        <option value="{{ $kel->id_praktikum }}">{{ $kel->nama_kelas }}</option>
                                        @endforeach
                                    </select>
                                    @error('id_kelas')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                     @enderror
                                </div>


                                    <button class="btn btn-bg--primary btn-size--md btn-hover--3d mx-1" type="submit"><span class="btn__text">Daftar</span></button>
                                </div>
                            </form>
                            <!-- end of form -->
                        </div>
                        <!-- end of from area -->
                    </div>
                    <!-- end of col -->
                </div>
                <!-- end of row -->
            </div>
            <!-- end of container -->
        </section>
        <!-- =========== End of Body ============ -->
    </main>
   <!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>-->
    <script type="text/javascript">
        $(document).ready(function(){

            $(document).on('change','.nim', function(){
                //console.log("berubah");

                var id_mahasiswa=$(this).val();
                //console.log(id_mahasiswa);

                var a=$(this).parent();
                console.log(id_mahasiswa);
                var op="";

                $.ajax({
                    type:'get',
                    url:'{!!URL::to('findnamamhs') !!}',
                    data:{'id_mahasiswa':id_mahasiswa},
                    dataType:'json',
                    success:function(data){
                        console.log("nama_mahasiswa");

                        console.log(data.nama_mahasiswa);

                        a.find('.namamhs').val(data.nama_mahasiswa);
                    },

                    error:function(){

                    }

                });
            });

        })
    </script>
    <script>
        $(document).ready(function() {
            $('#select2').select2();
        });
    </script>



</body>

</html>
