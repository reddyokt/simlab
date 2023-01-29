@extends('dashboard.layouts.main')

@section('container')
    <h3 class="h5 my-3 fw-normal text-center">Edit Kelas Praktikum</h3>
    <form action="/praktikum/editekelas/{{ $praktikum->id_praktikum }}" method="POST" class="col-md-5 d-block text-center mx-auto">
        @csrf
        <div class=" form-floating mb-1">
            <input type="text" name="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror"
            id="nama_kelas" placeholder="Nama Kelas" required value="{{ $praktikum->kelas->nama_kelas }}" disabled >
            <label for="name">Nama Kelas</label>
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror"
            id="nama_kelas" placeholder="Nama Kelas" required value="{{ $praktikum->periode->tahun_ajaran }}" disabled >
            <label for="name">Tahun Ajaran</label>
        </div>

        <div class=" form-floating mb-1 ">
            <select class="form-control" name="dosen_id" id="dosen_id" required aria-label="Floating label select example" >
                <option selected disabled >{{ $praktikum->dosen->nama_dosen }}</option>

            @foreach ( $dosens as $dosen )
                <option value="{{ $dosen->id_dosen }}">{{ $dosen->nama_dosen }}</option>
            @endforeach
            </select>
            <label for="dosen_id">Ganti Dosen?</label>
              @error('dosen_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
             @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="jumlah_modul" class="form-control @error('jumlah_modul') is-invalid @enderror"
            id="jumlah_modul" placeholder="Jumlah Modul" required value="{{ $praktikum->jumlah_modul }}" >
            <label for="phone">Jumlah Modul</label>
            @error('jumlah_modul')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror"
            id="nama_kelas" placeholder="Nama Kelas" required value="{{ $praktikum->is_active=='Y'?"Aktif": "Tidak Aktif"}}" disabled >
            <label for="name">Status Kelas Aktif?</label>
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Edit Kelas</button>
    </form>
@endsection
