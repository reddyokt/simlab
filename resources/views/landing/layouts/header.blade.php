<!--Navbar Start-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0/dist/css/bootstrap.min.css" rel="stylesheet" >
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.min.js" integrity="sha384-Atwg2Pkwv9vp0ygtn1JAojH0nYbwNJLPhwyoVbhoPwBhjQPR5VtM2+xf0Uwh9KtT" crossorigin="anonymous"></script>
    <script src="https://use.fontawesome.com/7c2dd59b38.js"></script>

<nav class="col-lg-12 navbar navbar-expand-lg fixed-top navbar-custom sticky sticky-dark bg-primary">
    <div class="container">
        <!-- LOGO -->
        <a class="navbar-brand logo text-uppercase" href="index-1.html">
            <img src="images/logo-light.png" class="logo-light" alt="" height="22">
            <img src="images/logo-dark.png" class="logo-dark" alt="" height="22">
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse"
            aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
            <i class="mdi mdi-menu"></i>
        </button>
        <div class="collapse navbar-collapse" id="navbarCollapse">
            <ul class="navbar-nav mx-auto navbar-center" id="mySidenav">
                <li class="nav-item active">
                    <a href="#home" class="nav-link">Home</a>
                </li>
                <!--<li class="nav-item">
                    <a href="#cta" class="nav-link">Daftar Praktikum</a>
                </li>-->
                <li class="nav-item">
                    <a href="#jadwal" class="nav-link">Jadwal Praktikum</a>
                </li>
                <li class="nav-item">
                    <a href="#pengumuman" class="nav-link">Pengumuman</a>
                </li>
                <li class="nav-item">
                    <a href="#download" class="nav-link">Download</a>
                </li>

            </ul>

            </ul>
            @auth
            <ul style="list-style-type:none;">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                    Welcome Back, {{ auth()->user()->nama_lengkap }}
                    </a>
                    <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="/dashboard">My Dashboard</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="/logout" method="post">
                                @csrf
                                <button type="submit" class="dropdown-item">Logout</button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>

                @else
                <div class="navbar-button d-none d-lg-inline-block">
                    <a href="/login" class="btn btn-md btn-custom-light btn-rounded btn-round text-white bg-success">Login</a>
                </div>
            @endauth
        </div>
    </div>
</nav>
<!-- Navbar End -->


