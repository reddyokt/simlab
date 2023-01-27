@extends('dashboard.layouts.main')

@section('container')
@if ($errors->any())
<div class="alert alert-danger">
    <ul>
        @foreach ($errors->all() as $error )
        <li> {{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif

    <h3 class="h5 my-3 fw-normal text-center">Tambah Akun SimLab</h3>
    <form action="/user/create" method="POST" class="col-md-5 d-block text-center mx-auto">
        @csrf
        <div class=" form-floating mb-1">
            <input type="text" name="username" class="form-control @error('username') is-invalid @enderror"
            id="username" placeholder="Name" required value="{{ old ('username') }}" >
            <label for="username">Username</label>
            @error('username')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class=" form-floating mb-1">
            <input type="text" name="nama_lengkap" class="form-control @error('nama_lengkap') is-invalid @enderror"
            id="nama_lengkap" placeholder="Nama Lengkap" required value="{{ old ('nama_lengkap') }}" >
            <label for="nama_lengkap">Nama Lengkap</label>
            @error('nama_lengkap')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class=" form-floating mb-1 ">
            <select class="form-control @error('role') is-invalid @enderror" name="role_id" id="role" required value="{{ old ('role') }}" >>
                <option selected disabled>Pilih Role/Jabatan</option>
                @foreach ($data as $dt)
                <option value="{{ $dt->id_role }}">{{ $dt->role_name }}</option>
                @endforeach
              </select>
              @error('role')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
             @enderror
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Buat Akun</button>
    </form>
@endsection
