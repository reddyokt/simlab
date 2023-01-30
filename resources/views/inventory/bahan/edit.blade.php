@extends('dashboard.layouts.main')

@section('container')
    <h3 class="h5 my-3 fw-normal text-center">Ubah Data Bahan Kimia</h3>
    <form action="/bahan/edit/{{$data->id_bahan}}" method="POST" class="col-md-5 d-block text-center mx-auto">
        @csrf
        <div class=" form-floating mb-1">
            <input type="text" name="nama_bahan" class="form-control @error('nama_bahan') is-invalid @enderror"
            id="nama_bahan" placeholder="Nama Bahan" required value="{{ $data->nama_bahan }}" >
            <label for="nama_bahan">Nama Bahan</label>
            @error('nama_bahan')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="rumus_kimia" class="form-control @error('rumus_kimia') is-invalid @enderror"
            id="rumus_kimia" placeholder="Rumus Kimia" required value="{{ $data->rumus }}" >
            <label for="rumus_kimia">Rumus Bahan Kimia</label>
            @error('rumus_kimia')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror"
            id="jumlah" placeholder="Jumlah(Dalam satuan gr/ml)" required value="{{ $data->jumlah }}" >
            <label for="jumlah">Jumlah(Dalam satuan gr/ml)</label>
            @error('jumlah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        {{-- <div class=" form-floating mb-1">
            <input type="text" name="lokasi_id" class="form-control @error('lokasi_id') is-invalid @enderror"
            id="jumlah" placeholder="Nama Lokasi" required value="{{ $data->lokasi->nama_lokasi }}" >
            <label for="lokasi_id">Jumlah(Dalam satuan gr/ml)</label>
            @error('lokasi_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div> --}}
        <button class="w-100 btn btn-lg btn-primary" type="submit">Buat Data Bahan Kimia</button>
    </form>
@endsection
