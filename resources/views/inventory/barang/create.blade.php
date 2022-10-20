@extends('dashboard.layouts.main')

@section('container')
    <h3 class="h5 my-3 fw-normal text-center">Tambah Barang Umum</h3>
    <form action="/inventory/barang/create" method="POST" class="col-md-5 d-block text-center mx-auto">
        @csrf
        <div class=" form-floating mb-1">
            <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror"
            id="nama_barang" placeholder="Nama Barang" required value="{{ old ('nama_barang') }}" >
            <label for="nama_barang">Nama Barang</label>
            @error('nama_barang')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="merk_barang" class="form-control @error('merk_barang') is-invalid @enderror"
            id="merk_barang" placeholder="Merk Barang" required value="{{ old ('merk_barang') }}" >
            <label for="merk_barang">Merk Barang</label>
            @error('merk_barang')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="ukuran_barang" class="form-control @error('ukuran_barang') is-invalid @enderror"
            id="ukuran_barang" placeholder="Ukuran Barang" required value="{{ old ('ukuran_barang') }}" >
            <label for="ukuran_barang">Ukuran Barang</label>
            @error('ukuran_barang')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="pabrikan_barang" class="form-control @error('pabrikan_barang') is-invalid @enderror"
            id="pabrikan_barang" placeholder="Pabrikan Barang"  value="{{ old ('pabrikan_barang') }}" >
            <label for="pabrikan_barang">Pabrikan Barang</label>
            @error('pabrikan_barang')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="jumlah_barang" class="form-control @error('jumlah_barang') is-invalid @enderror"
            id="jumlah_barang" placeholder="Jumlah Barang" required value="{{ old ('jumlah_barang') }}" >
            <label for="jumlah_barang">Jumlah Barang</label>
            @error('jumlah_barang')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="barang_rusak" class="form-control @error('barang_rusak') is-invalid @enderror"
            id="barang_rusak" placeholder="Barang Rusak" required value="{{ old ('barang_rusak') }}" >
            <label for="barang_rusak">Barang Rusak</label>
            @error('barang_rusak')
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

        <button class="w-100 btn btn-lg btn-primary" type="submit">Buat Data Barang</button>
    </form>
@endsection
