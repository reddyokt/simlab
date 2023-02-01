@extends('dashboard.layouts.main')

@section('container')
    <h3 class="h5 my-3 fw-normal text-center">Tambah Kategori Alat</h3>
    <form action="/masterdata/createnamapraktikum" method="POST" class="col-md-5 d-block text-center mx-auto">
        @csrf
        <div class=" form-floating mb-1">
            <input type="text" name="nama_kategori" class="form-control @error('nama_kategori') is-invalid @enderror"
            id="nama_kelas" placeholder="Nama Kategori" required value="{{ old ('nama_kategori') }}" >
            <label for="nama_kategori">Nama Kategori Alat</label>
            @error('nama_kategori')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class=" form-floating mb-1">
            <textarea type="textarea" name="keterangan" class="form-control @error('keterangan') is-invalid @enderror"
            id="kode_kelas" placeholder="keterangan" required value="{{ old ('keterangan') }}" >
            <label for="keterangan">Keterangan</label>
            @error('keterangan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Buat Nama Praktikum</button>
    </form>
@endsection
