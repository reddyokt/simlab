@extends('dashboard.layouts.main')

@section('container')
    <h3 class="h5 my-3 fw-normal text-center">Tambah Bahan Kimia</h3>
    <form action="/bahan/create" method="POST" class="col-md-5 d-block text-center mx-auto">
        @csrf
        <div class=" form-floating mb-1">
            <input type="text" name="nama_bahan" class="form-control @error('nama_bahan') is-invalid @enderror"
            id="nama_bahan" placeholder="Nama Bahan" required value="{{ old ('nama_bahan') }}" >
            <label for="nama_bahan">Nama Bahan</label>
            @error('nama_bahan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="rumus_kimia" class="form-control @error('rumus_kimia') is-invalid @enderror"
            id="rumus_kimia" placeholder="Rumus Kimia" required value="{{ old ('rumus_kimia') }}" >
            <label for="rumus_kimia">Rumus Bahan Kimia</label>
            @error('rumus_kimia')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror"
            id="jumlah" placeholder="Jumlah(Dalam satuan gr/ml)" required value="{{ old ('jumlah') }}" >
            <label for="jumlah">Jumlah(Dalam satuan gr/ml)</label>
            @error('jumlah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1 ">
            <select class="form-control @error('lokasi_id') is-invalid @enderror" name="lokasi_id" id="lokasi_id" placeholder="Pilih lokasi" required value="{{ old ('lokasi_id') }}" >
                <option selected disabled>Pilih Lokasi</option>
                @foreach ( $lokasi as $loc )
                <option value="{{ $loc->id_lokasi }}"> {{ $loc->nama_lokasi }}</option>
            @endforeach
              </select>
              @error('lokasi_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
             @enderror
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit">Buat Data Bahan Kimia</button>
    </form>
@endsection
