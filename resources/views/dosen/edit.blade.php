@extends('dashboard.layouts.main')

@section('container')
    <h3 class="h5 my-3 fw-normal text-center">Edit Dosen</h3>
    <form action="/edit/{{ $dosen->id_dosen }}" method="POST" class="col-md-5 d-block text-center mx-auto">
        @csrf
        <div class=" form-floating mb-1">
            <input type="text" name="nama_dosen" class="form-control @error('name') is-invalid @enderror"
            id="nama_dosen" placeholder="Nama Dosen" required value="{{ $dosen->nama_dosen }}" >
            <label for="nama_dosen">Nama Dosen</label>
            @error('nama_dosen')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="nidn" class="form-control @error('nidn') is-invalid @enderror"
            id="phone" placeholder="NIDN" required value="{{ $dosen->nidn }}" >
            <label for="nidn">NIDN</label>
            @error('phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Edit Data Dosen</button>
    </form>
@endsection
