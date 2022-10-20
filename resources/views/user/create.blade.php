@extends('dashboard.layouts.main')

@section('container')
    <h3 class="h5 my-3 fw-normal text-center">Tambah Akun SimLab</h3>
    <form action="/user/create" method="POST" class="col-md-5 d-block text-center mx-auto">
        @csrf
        <div class=" form-floating mb-1">
            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror"
            id="name" placeholder="Name" required value="{{ old ('name') }}" >
            <label for="name">Nama</label>
            @error('name')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class=" form-floating mb-1 ">
            <select class="form-control @error('role') is-invalid @enderror" name="role" id="role" required value="{{ old ('role') }}" >>
                <option selected disabled>Pilih Role/Jabatan</option>
                <option value="Kepala Lab">Kepala Lab</option>
                <option value="Assisten Lab">Assisten Lab</option>
                <option value="Laboran">Laboran</option>
              </select>
              @error('role')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
             @enderror
        </div>
        <div class=" form-floating mb-1">
            <input type="text" name="phone" class="form-control @error('phone') is-invalid @enderror"
            id="phone" placeholder="Phone" required value="{{ old ('phone') }}" >
            <label for="phone">Phone Number</label>
            @error('phone')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <div class=" form-floating mb-1">
            <input type="text" name="email" class="form-control @error('email') is-invalid @enderror"
            id="phone" placeholder="Email" required value="{{ old ('email') }}">
            <label for="email">Email</label>
            @error('email')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>
        <button class="w-100 btn btn-lg btn-primary" type="submit">Buat Akun</button>
    </form>
@endsection
