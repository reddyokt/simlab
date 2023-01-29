@extends('dashboard.layouts.main')


@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Assalamu'alaikum {{ auth()->user()->nama_lengkap }}</h1>
</div>
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
@endsection


