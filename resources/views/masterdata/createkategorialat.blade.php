@extends('dashboard.layouts.main')

@section('container')
    <h3 class="h5 my-3 fw-normal text-center">Tambah Kategori Alat</h3>
    <form action="/masterdata/createkategorialat" method="POST" class="col-md-5 d-block text-center mx-auto">
        @csrf
        <div class=" form-group mb-2">
            <input type="text" name="nama_kategori" class="form-control"
            id="nama_kelas" placeholder="Nama Kategori" required value="{{ old ('nama_kategori') }}" >
        </div>
        <div class="form-group mb-2">
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Keterangan" name="keterangan"></textarea>
          </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Buat Kategori Alat</button>
    </form>
@endsection
