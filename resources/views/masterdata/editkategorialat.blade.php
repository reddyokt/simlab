@extends('dashboard.layouts.main')

@section('container')
    <h3 class="h5 my-3 fw-normal text-center">Ubah Kategori Alat</h3>
    <form action="/masterdata/editkategorialat/{{ $kategorialat->id_kategori_alat }}" method="POST" class="col-md-5 d-block text-center mx-auto">
        @csrf
        <div class=" form-group mb-2">
            <label class="label" for="nama_kategori">Nama Kategori</label>
            <input type="text" name="nama_kategori" class="form-control"
            id="nama_kategori" placeholder="Nama Kategori" required value="{{ $kategorialat->nama_kategori}}" >
        </div>
        <div class="form-group mb-2">
            <label class="label" for="keterangan">Keterangan</label>
            <textarea class="form-control" id="keterangan" rows="3" placeholder="Keterangan" name="keterangan">{{ $kategorialat->keterangan}}</textarea>
          </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Ubah Kategori Alat</button>
    </form>
@endsection
