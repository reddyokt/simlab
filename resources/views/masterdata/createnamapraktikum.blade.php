@extends('dashboard.layouts.main')

@section('container')
    <h3 class="h5 my-3 fw-normal text-center">Tambah Nama Praktikum</h3>
    <form action="/masterdata/createnamapraktikum" method="POST" class="col-md-5 d-block text-center mx-auto">
        @csrf
        <div class=" form-floating mb-1">
            <input type="text" name="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror"
            id="nama_kelas" placeholder="Jumlah Modul" required value="{{ old ('nama_kelas') }}" >
            <label for="nama_kelas">Nama Kelas</label>
            @error('nama_kelas')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class=" form-floating mb-1">
            <input type="text" name="kode_kelas" class="form-control @error('kode_kelas') is-invalid @enderror"
            id="kode_kelas" placeholder="kode_kelas" required value="{{ old ('kode_kelas') }}" >
            <label for="kode_kelas">Kode Mata Kuliah</label>
            @error('kode_kelas')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class=" form-floating mb-1">
            <input type="text" name="jumlah_modul" class="form-control @error('jumlah_modul') is-invalid @enderror"
            id="jumlah_modul" placeholder="jumlah_modul" required value="{{ old ('jumlah_modul') }}" >
            <label for="jumlah_modul">Jumlah Modul Percobaan</label>
            @error('jumlah_modul')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Buat Nama Praktikum</button>
    </form>
@endsection
