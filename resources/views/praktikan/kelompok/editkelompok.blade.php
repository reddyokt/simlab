@extends('dashboard.layouts.main')

@section('container')
    <h3 class="h5 my-3 fw-normal text-center">Edit Kelompok/Pindah Kelompok</h3>
    <form action="/praktikan/editkelompok/{{$data->mahasiswa_id}}/{{$data->praktikum_id}}" method="POST" class="col-md-5 d-block text-center mx-auto">
        @csrf
        <div class=" form-floating mb-1">
            <input type="text" name="nama_mahasiswa" class="form-control @error('nama_mahasiswa') is-invalid @enderror"
            id="nama_mahasiswa" placeholder="Nama Mahasiswa" required value="{{ $data->mahasiswa->nama_mahasiswa }}" disabled>
            <label for="nama_mahasiswa">Nama Mahasiswa</label>

        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="nama_mahasiswa" class="form-control @error('nama_mahasiswa') is-invalid @enderror"
            id="nama_mahasiswa" placeholder="Nama Mahasiswa" required value="{{ $data->praktikum->kelas->nama_kelas }}" disabled>
            <label for="nama_mahasiswa">Nama Kelas</label>

        </div>

        <div class=" form-floating mb-1 ">
            <select class="form-control" name="kelompok_id" id="kelompok_id" placeholder="Pilih Kelompok" required>
                <option selected disabled>Pilih Kelompok</option>
                @foreach ( $kelompok as $klm )
                <option {{$klm->id_kelompok==$data->kelompok_id ? "selected" : ""}} value="{{$klm->id_kelompok}}"> {{ $klm->nama_kelompok }}</option>
                @endforeach
              </select>

        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Ganti Kelompok</button>
    </form>
@endsection
