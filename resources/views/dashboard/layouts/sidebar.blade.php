<style>
            .b-example-divider {
            flex-shrink: 0;
            width: 1.5rem;
            height: 100vh;
            background-color: rgba(0, 0, 0, .1);
            border: solid rgba(0, 0, 0, .15);
            border-width: 1px 0;
            box-shadow: inset 0 .5em 1.5em rgba(0, 0, 0, .1), inset 0 .125em .5em rgba(0, 0, 0, .15);
            }

            .bi {
            vertical-align: -.125em;
            pointer-events: none;
            fill: currentColor;
            }

            .dropdown-toggle { outline: 0; }

            .nav-flush .nav-link {
            border-radius: 0;
            }

            .btn-toggle {
            display: inline-flex;
            align-items: center;
            padding: .25rem .5rem;
            font-weight: 600;
            color: rgba(0, 0, 0, .65);
            background-color: transparent;
            border: 0;
            }
            .btn-toggle:hover,
            .btn-toggle:focus {
            color: rgba(0, 0, 0, .85);
            background-color: #d2f4ea;
            }

            .btn-toggle::before {
            width: 1.25em;
            line-height: 0;
            content: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='rgba%280,0,0,.5%29' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M5 14l6-6-6-6'/%3e%3c/svg%3e");
            transition: transform .35s ease;
            transform-origin: .5em 50%;
            }

            .btn-toggle[aria-expanded="true"] {
            color: rgba(0, 0, 0, .85);
            }
            .btn-toggle[aria-expanded="true"]::before {
            transform: rotate(90deg);
            }

            .btn-toggle-nav a {
            display: inline-flex;
            padding: .1875rem .5rem;
            margin-top: .125rem;
            margin-left: 1.25rem;
            text-decoration: none;
            }
            .btn-toggle-nav a:hover,
            .btn-toggle-nav a:focus {
            background-color: #d2f4ea;
            }

            .scrollarea {
            overflow-y: auto;
            }

            .fw-semibold { font-weight: 600; }
            .lh-tight { line-height: 1.25; }

</style>
@auth
<div class="container-fluid">
  <div class="row">
        <nav id="sidebarMenu" class="col-md-3 col-lg-2 d-md-block bg-light sidebar collapse">
            <div class="position-sticky pt-3">
                    <ul class="list-unstyled ps-0">
                    <li class="mb-1">
                        <a href="/dashboard">
                        <button class="btn  align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#home-collapse" aria-expanded="false">
                        Dashboard
                        </button></a>
                    </li>

                    @if (auth()->user()->role_id =="1" or auth()->user()->role_id =="2" or auth()->user()->role_id =="4")
                    <li class="mb-1">
                        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#praktikum-collapse" aria-expanded="false">
                            <span class="mx-3" data-feather="book-open"></span> Praktikum
                        </button>
                        <div class="collapse" id="praktikum-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 big mt-2">
                            @if (auth()->user()->role_id =="1")
                            <li><a href="/periode" class="link-dark rounded">Periode</a></li>
                            <li><a href="/kelas" class="link-dark rounded">Kelas Praktikum</a></li>
                            @endif
                            <li><a href="/modul" class="link-dark rounded">Modul Praktikum</a></li>
                        </ul>
                        </div>
                    </li>


                    <li class="mb-1">
                        <button class="btn btn-toggle align-items-center rounded collapsed"
                        data-bs-toggle="collapse" data-bs-target="#praktikan-collapse" aria-expanded="false">
                            <span class="mx-3" data-feather="slack"></span> Praktikan
                        </button>
                        <div class="collapse" id="praktikan-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 big mt-2">
                            <li><a href="/praktikan/peserta" class="link-dark rounded">Daftar Peserta</a></li>
                            <li><a href="/praktikan/kelompok" class="link-dark rounded">Kelompok</a></li>
                            <li><a href="/praktikan/absen" class="link-dark rounded">Absen</a></li>
                            <li><a href="/praktikan/tugas" class="link-dark rounded">Tugas</a></li>
                            <li><a href="/praktikan/ujian" class="link-dark rounded">Ujian</a></li>
                            @if (auth()->user()->role_id =="2" or auth()->user()->role_id =="1")
                            <li><a href="/praktikan/validasitugas" class="link-dark rounded">Validasi Tugas</a></li>
                            <li><a href="/praktikan/validasiujian" class="link-dark rounded">Validasi Ujian</a></li>
                            @endif
                            <li><a href="/praktikan/penilaiantugas" class="link-dark rounded">Nilai Tugas</a></li>
                            <li><a href="/praktikan/penilaianujian" class="link-dark rounded">Nilai Ujian</a></li>
                            <li><a href="/praktikan/penilaianakhir" class="link-dark rounded">Nilai Akhir</a></li>
                        </ul>
                        </div>
                    </li>
                    @endif

                    @if (auth()->user()->role_id =='3' or auth()->user()->role_id =="1")
                    <li class="mb-1">
                        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#inventory-collapse" aria-expanded="false">
                            <span class="mx-3" data-feather="shopping-bag"></span> Inventory
                        </button>
                        <div class="collapse" id="inventory-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 big mt-2">
                            <li><a href="/alat" class="link-dark rounded">Alat Praktikum</a></li>
                            <li><a href="/inventory/bahan" class="link-dark rounded">Bahan Praktikum</a></li>
                            <li><a href="/inventory/barang" class="link-dark rounded">Barang Umum</a></li>
                            <li><a href="/inventory/transaksi" class="link-dark rounded">Transaksi</a></li>
                        </ul>
                        </div>
                    </li>
                    @endif

                    @if (auth()->user()->role_id =="3")
                    <li class="mb-1">
                        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#akun-collapse" aria-expanded="false">
                            <span class="mx-3" data-feather="users"></span> Master Akun
                        </button>
                        <div class="collapse" id="akun-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 big mt-2">
                            <li><a href="/user" class="link-dark rounded">Admin</a></li>
                            <li><a href="/dosen" class="link-dark rounded">Dosen</a></li>
                            <li><a href="/mahasiswa" class="link-dark rounded">Mahasiswa</a></li>
                        </ul>
                        </div>
                    </li>
                    @endif

                    @if (auth()->user()->role_id =='3' or auth()->user()->role_id =="1" or auth()->user()->role_id =="4")
                    <li class="mb-1">
                        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#landing-collapse" aria-expanded="false">
                            <span class="mx-3" data-feather="layout"></span> Landing Page
                        </button>
                        <div class="collapse" id="landing-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 big mt-2">
                            <li><a href="/pengumuman" class="link-dark rounded">Pengumuman</a></li>
                            <li><a href="/download" class="link-dark rounded">Download</a></li>
                        </ul>
                        </div>
                    </li>
                    @endif
                    @if (auth()->user()->role_id =='1')
                    <li class="mb-1">
                        <button class="btn btn-toggle align-items-center rounded collapsed" data-bs-toggle="collapse" data-bs-target="#data-collapse" aria-expanded="false">
                            <span class="mx-3" data-feather="file"></span> Master Data
                        </button>
                        <div class="collapse" id="data-collapse">
                        <ul class="btn-toggle-nav list-unstyled fw-normal pb-1 big mt-2">
                            <li><a href="/masterdata/indexpraktikum" class="link-dark rounded">Data Nama Praktikum</a></li>
                            <li><a href="/masterdata/indexkomposisinilai" class="link-dark rounded">Komposisi Nilai</a></li>
                            <li><a href="/masterdata/indexkategorialat" class="link-dark rounded">Kategori Alat</a></li>
                        </ul>
                        </div>
                    </li>
                    @endif
                    </ul>
            </div>
        </nav>
  </div>
@endauth
</div>
