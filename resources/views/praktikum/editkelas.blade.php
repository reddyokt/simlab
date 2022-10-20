@extends('dashboard.layouts.main')

@section('container')
    <h3 class="h5 my-3 fw-normal text-center">Edit Kelas Praktikum</h3>
    <form action="/praktikum/editekelas/{{ $praktikum->id_praktikum }}" method="POST" class="col-md-5 d-block text-center mx-auto">
        @csrf
        <div class=" form-floating mb-1">
            <input type="text" name="nama_kelas" class="form-control @error('nama_kelas') is-invalid @enderror"
            id="nama_kelas" placeholder="Nama Kelas" required value="{{ $praktikum->nama_kelas }}" >
            <label for="name">Nama Kelas</label>
            @error('nama_kelas')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1 ">
            <select class="form-control" name="tahun_ajaran" id="tahun_ajaran" value="{{ $praktikum->tahun_ajaran  }}">
                <?php
                $year = date('2022')+10;
                ?>
                @for($i=date('2022');$i<=$year;$i++)
                    <option value="{{$i}} - {{$i+1}}">{{$i}} / {{$i+1}}</option>
                @endfor
            </select>
            @error('tahun_ajaran')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
             @enderror
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
            <input type="text" name="modul" class="form-control @error('modul') is-invalid @enderror"
            id="phone" placeholder="Modul" required value="{{ $praktikum->modul }}" >
            <label for="phone">Jumlah Modul</label>
            @error('modul')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class="form-floating">
            <select class="form-control" id="is_active" name="is_active" aria-label="Floating label select example">
              <option selected>{{ $praktikum->is_active }}</option>
              <option value="YA"> YA </option>
              <option value="TIDAK"> TIDAK </option>
            </select>
            <label for="is_active">Kelas Aktif?</label>
            @error('is_active')
            <div class="invalid-feedback">
                {{ $message }}
            </div>
            @enderror
          </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Edit Kelas</button>
    </form>
@endsection
