@extends('dashboard.layouts.main')

@section('container')
    <h3 class="h5 my-3 fw-normal text-center">Tambah Alat Praktikum </h3>



    {{-- @dd($data->kategori) --}}
    <form action="/editalat/{{ $data->id_alat_praktikum }}" method="POST" class="col-md-5 d-block text-center mx-auto">
        @csrf
        <div class=" form-floating mb-1 ">
            <select class="form-control" name="kategori_alat_id" placeholder="Pilih Jenis Alat" >
                    @foreach ($kategori as $k )
                        <option {{ $k->id_kategori_alat == $data->kategori_alat_id ? 'selected' : "" }} value="{{ $k->id_kategori_alat }}"> {{ $k->nama_kategori }}</option>
                    @endforeach
              </select>
        </div>
        <div class=" form-floating mb-1">
            <input type="text" name="nama_alat" class="form-control"
            id="nama_alat" placeholder="Nama Alat" value="{{ $data->nama_alat }}" >
            <label for="nama_alat_c2a">Nama Alat</label>
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="merk" class="form-control"
            id="merk" placeholder="Merk Alat" value="{{ $data->merk }}">
            <label for="merk">Merk Alat</label>
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="ukuran" class="form-control"
            id="ukuran" placeholder="Ukuran Alat" value="{{ $data->ukuran }}">
            <label for="ukuran">Ukuran Alat</label>
        </div>


        <div class=" form-floating mb-1">
            <input type="text" name="jumlah" class="form-control"
            id="jumlah" placeholder="Jumlah Alat" value="{{ $data->jumlah }}">
            <label for="jumlah">Jumlah Alat</label>
        </div>

        <div class=" form-floating mb-1 ">
            <select class="form-control" name="lokasi_id" id="lemari_id" placeholder="Pilih Lokasi" >
                @foreach ($lokasi as $l )
                    <option {{ $l->id_lokasi == $data->lokasi_id ? 'selected' : ""}} value="{{ $l->id_lokasi }}"> {{ $l->nama_lokasi }}</option>
                @endforeach
              </select>
        </div>

        <div class=" form-floating mb-1 ">
            <select class="form-control" name="lemari_id" id="lemari_id" placeholder="Pilih Lemari" >
                @foreach ($lemari as $le )
                    <option {{ $le->id_lemari == $data->lemari_id ? 'selected' : ""}} value="{{ $le->id_lemari }}"> {{ $le->nama_lemari }}</option>
                @endforeach
              </select>
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="baris" class="form-control"
            id="baris" placeholder="Baris" value="{{ $data->baris }}">
            <label for="baris">Baris ke?</label>
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="kolom" class="form-control"
            id="kolom" placeholder="Kolom" value="{{ $data->kolom }}">
            <label for="kolom">Kolom ke?</label>
        </div>

        <div class="form-group mb-2">
            <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" placeholder="Keterangan" name="keterangan"></textarea>
          </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Ubah Data Alat Praktikum</button>
    </form>
@endsection
