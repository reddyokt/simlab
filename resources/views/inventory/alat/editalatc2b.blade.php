@extends('dashboard.layouts.main')

@section('container')
    <h3 class="h5 my-3 fw-normal text-center">Edit Alat C2B</h3>
    <form action="/editc2b/{{ $c2b_alat->id_alat }}" method="POST" class="col-md-5 d-block text-center mx-auto">
        @csrf
        <div class=" form-floating mb-1">
            <input type="text" name="nama_alat" class="form-control @error('nama_alat') is-invalid @enderror"
            id="nama_alat" placeholder="Nama Alat" required value="{{ $c2b_alat->nama_alat }}" >
            <label for="nama_alat">Nama Alat</label>
            @error('nama_alat')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="merk" class="form-control @error('merk') is-invalid @enderror"
            id="merk" placeholder="Merk Alat" required value="{{ $c2b_alat->merkt }}" >
            <label for="merk">Merk Alat</label>
            @error('merk')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="ukuran" class="form-control @error('ukuran') is-invalid @enderror"
            id="ukuran" placeholder="Ukuran Alat" required value="{{ $c2b_alat->ukuran }}" >
            <label for="ukuran">Ukuran Alat</label>
            @error('ukuran')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="pabrikan" class="form-control"
            id="pabrikan" placeholder="Pabrikan Alat" value="{{  $c2b_alat->pabrikan  }}" >
            <label for="pabrikan">Pabrikan Alat</label>
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="jumlah" class="form-control @error('jumlah') is-invalid @enderror"
            id="jumlah" placeholder="Jumlah Alat" required value="{{  $c2b_alat->jumlah  }}" >
            <label for="jumlah">Jumlah Alat</label>
            @error('jumlah')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="rusak" class="form-control @error('rusak') is-invalid @enderror"
            id="rusak" placeholder="Rusak Alat" required value="{{ $c2b_alat->rusak  }}" >
            <label for="rusak">Alat Rusak</label>
            @error('rusak')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-floating">
            <select class="form-control" id="lokasi_id" name="lokasi_id" aria-label="Floating label select example">
              <option value ="{{ $c2b_alat->lokasi->id_lokasi }}"selected>{{ $c2b_alat->lokasi->nama_lokasi }}</option>
              @foreach ( $lokasi as $lok )
              <option value="{{ $lok->id_lokasi }}"> {{ $lok->nama_lokasi }} </option>
              @endforeach
            </select>
            <label for="lokasi_id">Pilih Lokasi</label>
            @error('lokasi')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
          </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Ubah Data Alat C2A</button>
    </form>
@endsection
