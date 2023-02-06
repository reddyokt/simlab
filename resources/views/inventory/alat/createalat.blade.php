@extends('dashboard.layouts.main')

@section('container')
    <h3 class="h5 my-3 fw-normal text-center">Tambah Alat Praktikum </h3>
    <form action="/createalat" method="POST" class="col-md-5 d-block text-center mx-auto">
        @csrf

        <div class=" form-floating mb-1 ">
            <select class="form-control" name="kategori_id" placeholder="Pilih Jenis Alat" required>
                <option selected disabled>Pilih Jenis Alat</option>
                @foreach ( $kategori as $kategori )
                <option value="{{ $kategori->id_kategori_alat }}"> {{ $kategori->nama_kategori }}</option>
            @endforeach
              </select>
        </div>
        <div class=" form-floating mb-1">
            <input type="text" name="nama_alat" class="form-control"
            id="nama_alat" placeholder="Nama Alat" required >
            <label for="nama_alat_c2a">Nama Alat</label>
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="merk" class="form-control"
            id="merk" placeholder="Merk Alat">
            <label for="merk">Merk Alat</label>
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="ukuran" class="form-control"
            id="ukuran" placeholder="Ukuran Alat" >
            <label for="ukuran">Ukuran Alat</label>
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="jumlah_alat" class="form-control"
            id="jumlah" placeholder="Jumlah Alat" required>
            <label for="jumlah">Jumlah Alat</label>
        </div>

        <div class=" form-floating mb-1 ">
            <select class="form-control" name="lokasi_id" id="lemari_id" placeholder="Pilih Lemari" >
                <option selected disabled>Pilih Lokasi</option>
                @foreach ( $lokasi as $lokasi )
                <option value="{{ $lokasi->id_lokasi }}"> {{ $lokasi->nama_lokasi }}</option>
            @endforeach
              </select>
        </div>

        <div class=" form-floating mb-1 ">
            <select class="form-control" name="lemari_id" id="lemari_id" placeholder="Pilih Lemari" >
                <option selected disabled>Pilih Lemari</option>
                @foreach ( $lemari as $lemari )
                <option value="{{ $lemari->id_lemari }}"> {{ $lemari->nama_lemari }}</option>
            @endforeach
              </select>
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="baris" class="form-control"
            id="baris" placeholder="Baris" >
            <label for="baris">Baris ke?</label>
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="kolom" class="form-control"
            id="kolom" placeholder="Kolom" >
            <label for="kolom">Kolom ke?</label>
        </div>

        <div class="form-group mb-2">
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Keterangan" name="keterangan"></textarea>
          </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Buat Data Alat Praktikum</button>
    </form>
@endsection
