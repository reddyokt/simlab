@extends('dashboard.layouts.main')


@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Assalamu'alaikum {{ auth()->user()->nama_lengkap }}</h1>
</div>

  <div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">

            <div class="row">
                <div class="col-md-6">
                    <div class="card bg-primary text-white mb-4">
                        <div class="card-body">
                            @foreach ($data as $dt)
                            @if ( $dt->periode->status_periode=='Aktif')
                            <h4>Periode Aktif</h4>
                            <p>Kelas Aktif : {{$dt->kelas->nama_kelas}}</p>
                                @else  
                                <h4>Tidak Ada Periode Aktif</h4>
                            @endif
                            @endforeach
                        </div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card bg-warning text-white mb-4">
                        <div class="card-body">Warning Card</div>
                        <div class="card-footer d-flex align-items-center justify-content-between">
                            <div class="small text-white"><i class="fas fa-angle-right"></i></div>
                        </div>
                    </div>
                </div>
        </div>
    </div>
    </main>
    <footer class="py-4 bg-light mt-auto">
        <div class="container-fluid px-4">
            <div class="d-flex align-items-center justify-content-between small">
                <div class="text-muted">Copyright &copy; Your Website 2022</div>
                <div>
                    <a href="#">Privacy Policy</a>
                    &middot;
                    <a href="#">Terms &amp; Conditions</a>
                </div>
            </div>
        </div>
    </footer>
</div>

@endsection


