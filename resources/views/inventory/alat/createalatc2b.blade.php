@extends('dashboard.layouts.main')

@section('container')
    <h3 class="h5 my-3 fw-normal text-center">Tambah Alat C2B</h3>
    <form action="/alat/createalatc2b" method="POST" class="col-md-5 d-block text-center mx-auto">
        @csrf
        <div class=" form-floating mb-1">
            <input type="text" name="nama_alat" class="form-control @error('nama_alat_c2b') is-invalid @enderror"
            id="nama_alat_c2b" placeholder="Nama Alat" required value="{{ old ('nama_alat_c2b') }}" >
            <label for="nama_alat_c2b">Nama Alat</label>
            @error('nama_alat_c2b')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="merk" class="form-control @error('merk') is-invalid @enderror"
            id="merk" placeholder="Merk Alat" required value="{{ old ('merk') }}" >
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
            <input type="text" name="pabrikan" class="form-control"
            id="pabrikan" placeholder="Pabrikan Alat" value="{{ old ('pabrikan') }}" >
            <label for="pabrikan">Pabrikan Alat</label>
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
            id="rusak" placeholder="Alat Rusak" required value="{{ old ('rusak') }}" >
            <label for="rusak">Alat Rusak</label>
            @error('rusak')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-floating">
            <select class="form-control" id="lokasi_id" name="lokasi_id" aria-label="Floating label select example">
              <option selected></option>
              @foreach ( $lokasi as $lok )
              <option value="{{ $lok->id_lokasi }}"> {{ $lok->nama_lokasi }} </option>
              @endforeach
            </select>
            <label for="lokasi_id">Pilih Lokasi</label>
            @error('lokasi_id')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
          </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Buat Data Alat C2B</button>
    </form>
@endsection
