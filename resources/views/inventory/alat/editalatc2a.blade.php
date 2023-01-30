@extends('dashboard.layouts.main')

@section('container')
    <h3 class="h5 my-3 fw-normal text-center">Edit Alat C2A</h3>
    <form action="/editc2a/{{ $c2a_alat->id_alat }}" method="POST" class="col-md-5 d-block text-center mx-auto">
        @csrf
        <div class=" form-floating mb-1">
            <input type="text" name="nama_alat" class="form-control @error('nama_alat') is-invalid @enderror"
            id="nama_alat" placeholder="Nama Alat"  value="{{ $c2a_alat->nama_alat }}" >
            <label for="nama_alat">Nama Alat</label>
            @error('nama_alat')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="merk" class="form-control @error('merk') is-invalid @enderror"
            id="merk" placeholder="Merk Alat"  value="{{ $c2a_alat->merk}}" >
            <label for="merk">Merk Alat</label>
            @error('merk')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="ukuran" class="form-control @error('ukuran') is-invalid @enderror"
            id="ukuran" placeholder="Ukuran Alat"  value="{{ $c2a_alat->ukuran }}" >
            <label for="ukuran">Ukuran Alat</label>
            @error('ukuran')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror"
            id="jumlah" placeholder="Jumlah Alat"  value="{{ $c2a_alat->jumlah}}" >
            <label for="jumlah">Jumlah Alat</label>
            @error('jumlah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="rusak" class="form-control @error('rusak') is-invalid @enderror"
            id="rusak" placeholder="Rusak Alat"  value="{{ $c2a_alat->rusak }}" >
            <label for="rusak">Rusak Alat</label>
            @error('rusak')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1 ">
            <select class="form-control @error('lemari') is-invalid @enderror" name="lemari_id" id="lemari_id" placeholder="Pilih Lemari" required value="{{ old ('lemari_id') }}" >
                @foreach ( $lemari as $l )
                    <option {{ $c2a_alat->lemari_id == $l->id_lemari ? 'selected' : "" }} value={{$l->id_lemari}}>{{ $l->nama_lemari }}</option>
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
            id="baris" placeholder="Baris" required value="{{  $c2a_alat->baris }}" >
            <label for="baris">Baris ke?</label>
            @error('baris')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="kolom" class="form-control @error('kolom') is-invalid @enderror"
            id="kolom" placeholder="Kolom" required value="{{ $c2a_alat->kolom  }}" >
            <label for="kolom">Kolom ke?</label>
            @error('kolom')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Ubah Data Alat C2A</button>
    </form>
@endsection
