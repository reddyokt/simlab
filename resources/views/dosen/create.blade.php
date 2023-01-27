@extends('dashboard.layouts.main')

@section('container')
    <h3 class="h5 my-3 fw-normal text-center">Tambah Dosen</h3>
    <form action="/dosen/create" method="POST" class="col-md-8 d-block text-center mx-auto">
        @csrf
        <input type="hidden" value="2" name="role_id">

        <div class="input-group mb-3">
            <span class="input-group-text border-0" id="nidn-addon"><i class="fas fa-search"></i></span>
            <input
              name="nidn"
              type="text"
              class="form-control rounded"
              placeholder="NIDN"
              aria-label="nidn"
              aria-describedby="nidn-addon"
            />
          </div>
          <div class="input-group mb-3">
            <span class="input-group-text border-0" id="namalengkap-addon"><i class="fas fa-search"></i></span>
            <input
              name="nama_lengkap"
              type="text"
              class="form-control rounded"
              placeholder="Nama Lengkap"
              aria-label="namalengkap"
              aria-describedby="namalengkap-addon"
            />
          </div>

        {{-- <div class=" form-floating mb-1">
            <input type="text" name="nama_dosen" class="form-control @error('name') is-invalid @enderror"
            id="nama_dosen" placeholder="Nama Dosen" required value="{{ old ('nama_dosen') }}" >
            <label for="nama_dosen">Nama Dosen</label>
            @error('nama_dosen')
                <div class="invalid-feedback">
                    {{ $message }}
                </div>
            @enderror
        </div>

        <div class=" form-floating mb-1">
            <input type="text" name="nidn" class="form-control @error('nidn') is-invalid @enderror"
            id="phone" placeholder="NIDN" required value="{{ old ('nidn') }}" >
            <label for="nidn">NIDN</label>
            @error('phone')
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
        </div>--}}

        <button class="btn btn-lg btn-primary mt-2" type="submit">Buat Data Dosen</button>
    </form>
@endsection
