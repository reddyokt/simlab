@extends('dashboard.layouts.main')

@section('container')
    <h3 class="h5 my-3 fw-normal text-center">Tambah Alat C2A</h3>
    <form action="/alat/createalatc2a" method="POST" class="col-md-5 d-block text-center mx-auto">
        @csrf
        <div class=" form-floating mb-1">
            <input type="text" name="nama_alat" class="form-control @error('nama_alat_c2a') is-invalid @enderror"
            id="nama_alat_c2a" placeholder="Nama Alat" required value="{{ old ('nama_alat_c2a') }}" >
            <label for="nama_alat_c2a">Nama Alat</label>
            @error('nama_alat_c2a')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="merk" class="form-control @error('merk') is-invalid @enderror"
            id="merk" placeholder="Merk Alat"  value="{{ old ('merk') }}" >
            <label for="merk">Merk Alat</label>
            @error('merk')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="ukuran" class="form-control @error('ukuran') is-invalid @enderror"
            id="ukuran" placeholder="Ukuran Alat" required value="{{ old ('ukuran') }}" >
            <label for="ukuran">Ukuran Alat</label>
            @error('ukuran')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror"
            id="jumlah" placeholder="Jumlah Alat" required value="{{ old ('jumlah') }}" >
            <label for="jumlah">Jumlah Alat</label>
            @error('jumlah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="rusak" class="form-control @error('rusak') is-invalid @enderror"
            id="rusak" placeholder="Rusak Alat" required value="{{ old ('rusak') }}" >
            <label for="rusak">Alat Rusak</label>
            @error('rusak')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1 ">
            <select class="form-control @error('lemari') is-invalid @enderror" name="lemari_id" id="lemari_id" placeholder="Pilih Lemari" required value="{{ old ('lemari_id') }}" >>
                <option selected disabled>Pilih Lemari</option>
                @foreach ( $lemaris as $lemari )
                <option value="{{ $lemari->id_lemari }}"> {{ $lemari->nama_lemari }}</option>
            @endforeach
              </select>
              @error('lemari')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
             @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="baris" class="form-control @error('baris') is-invalid @enderror"
            id="baris" placeholder="Baris" required value="{{ old ('baris') }}" >
            <label for="baris">Baris ke?</label>
            @error('baris')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="kolom" class="form-control @error('kolom') is-invalid @enderror"
            id="kolom" placeholder="Kolom" required value="{{ old ('kolom') }}" >
            <label for="kolom">Kolom ke?</label>
            @error('kolom')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Buat Data Alat C2A</button>
    </form>
@endsection
