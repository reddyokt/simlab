@extends('dashboard.layouts.main')

@section('container')
    <h3 class="h5 my-3 fw-normal text-center">Ubah Barang Umum</h3>
    <form action="/editbarang/{{$barang->id_barang}}" method="POST" class="col-md-5 d-block text-center mx-auto">
        @csrf
        <div class=" form-floating mb-1">
            <input type="text" name="nama_barang" class="form-control @error('nama_barang') is-invalid @enderror"
            id="nama_barang" placeholder="Nama Barang" required value="{{ $barang->nama_barang }}" >
            <label for="nama_barang">Nama Barang</label>
            @error('nama_barang')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="merk_barang" class="form-control @error('merk_barang') is-invalid @enderror"
            id="merk_barang" placeholder="Merk Barang" required value="{{ $barang->merk_barang }}" >
            <label for="merk_barang">Merk Barang</label>
            @error('merk_barang')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="ukuran_barang" class="form-control @error('ukuran_barang') is-invalid @enderror"
            id="ukuran_barang" placeholder="Ukuran Barang" required value="{{ $barang->ukuran_barang }}" >
            <label for="ukuran_barang">Ukuran Barang</label>
            @error('ukuran_barang')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="pabrik_barang" class="form-control @error('pabrik_barang') is-invalid @enderror"
            id="pabrik_barang" placeholder="Pabrik Barang"  value="{{ $barang->pabrik_barang }}" >
            <label for="pabrik_barang">Pabrik Barang</label>
            @error('pabrik_barang')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="jumlah_barang" class="form-control @error('jumlah_barang') is-invalid @enderror"
            id="jumlah_barang" placeholder="Jumlah Barang" required value="{{ $barang->jumlah_barang }}" >
            <label for="jumlah_barang">Jumlah Barang</label>
            @error('jumlah_barang')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="barang_rusak" class="form-control @error('barang_rusak') is-invalid @enderror"
            id="barang_rusak" placeholder="Barang Rusak" required value="{{ $barang->barang_rusak }}" >
            <label for="barang_rusak">Barang Rusak</label>
            @error('barang_rusak')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1 ">
            <select class="form-control @error('lokasi_id') is-invalid @enderror" name="lokasi_id" id="lokasi_id" placeholder="Pilih lokasi" required >
            @foreach ( $lokasi as $loc )
                <option {{ $barang->lokasi_id == $loc->id_lokasi ? 'selected' : ""}} value="{{ $loc->id_lokasi }}"> {{ $loc->nama_lokasi }}</option>
            @endforeach
              </select>
              @error('lokasi_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
             @enderror
        </div>

        <button class="w-100 btn btn-lg btn-primary" type="submit">Ubah Data Barang</button>
    </form>
@endsection
