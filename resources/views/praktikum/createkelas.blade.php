@extends('dashboard.layouts.main')

@section('container')
    <h3 class="h5 my-3 fw-normal text-center">Tambah Kelas Praktikum</h3>
    <form action="/praktikum/createkelas" method="POST" class="col-md-5 d-block text-center mx-auto">
        @csrf
        <div class=" form-floating mb-1">
            <input type="text" name="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror"
            id="nama_kelas" placeholder="Nama Kelas" required value="{{ old ('nama_kelas') }}" >
            <label for="nama_kelas">Nama Kelas</label>
            @error('nama_kelas')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class=" form-floating mb-1">
            <select class="form-control" name="nama_praktikum" id="nama_praktikum" value="{{ old ('nama_praktikum') }}">
                <option selected disabled>Pilih Praktikum</option>
                @foreach ( $kelas as $kel )
                <option value="{{ $kel->id_kelas }}">{{ $kel->nama_kelas }} | {{ $kel->kode_kelas }}</option>
                @endforeach
            </select>
            @error('nama_praktikum')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1 ">
            <select class="form-control" name="periode" id="periode" value="{{ old ('periode') }}">
                <option selected disabled>Pilih Periode</option>
                @foreach ( $periode as $per )
                <option value="{{ $per->id_periode }}">{{ $per->tahun_ajaran }} | {{ $per->semester }}</option>
                @endforeach
            </select>
            @error('periode')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
             @enderror
        </div>

        <div class=" form-floating mb-1 ">
            <select class="form-control" name="dosen_id" dosen_id="dosen_id" required value="{{ old ('dosen_id') }}" >
                <option selected disabled>Pilih Dosen</option>
            @foreach ( $dosens as $dosen )
                <option value="{{ $dosen->id_dosen }}">{{ $dosen->nama_dosen }}</option>
            @endforeach
            </select>

              @error('dosen_id')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
             @enderror
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Buat Kelas</button>
    </form>
@endsection
