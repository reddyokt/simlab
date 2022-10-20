@extends('dashboard.layouts.main')

@section('container')
@if (session()-> has('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
@endif

<div class="row gx-4 mt-4 ">
    <div class="p-3 card col-md-6">
        <div class="card-header bg-info mt-2">
            <h5 class="card-title text-center"> Tambah Data Lemari</h5>
          </div>
          <div class="card-body">
        <form action="/inventory/alat/createlemari" method="POST" class="col-md">
            @csrf
            <div class=" form-floating mb-1">
                <input type="text" name="nama_lemari" class="form-control @error('nama_lemari') is-invalid @enderror"
                id="nama_lemari" placeholder="Nama Lemari" required value="{{ old ('nama_lemari') }}" >
                <label for="nama_lemari">Nama Lemari</label>
                @error('nama_lemari')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <div class=" form-floating mb-1 ">
                <select class="form-control" name="id_lokasi" id="id_lokasi" required value="{{ old ('id_lokasi') }}" >
                    <option selected disabled>Pilih Lokasi</option>
                @foreach ( $location as $locs )
                    <option value="{{ $locs->id_lokasi}}">{{ $locs->nama_lokasi }}</option>
                @endforeach
                </select>

                  @error('id_lokasi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                 @enderror
            </div>
            <button class="w-100 btn btn-lg btn-info" type="submit">Buat Data Lemari</button>
        </form>
    </div>
</div>

<!--------------------------------------------------------------Lokasi-------------------------------------------------->
<div class="p-3 card col-md-6">
    <div class="card-header bg-warning mt-2">
        <h5 class="card-title text-center"> Tambah Data Lokasi</h5>
      </div>
      <div class="card-body">
        <form action="/inventory/alat/createlokasi" method="POST" class="col-md">
            @csrf
            <div class=" form-floating mb-1">
                <input type="text" name="nama_lokasi" class="form-control @error('nama_lokasi') is-invalid @enderror"
                id="nama_lokasi" placeholder="Nama lokasi" required value="{{ old ('nama_lokasi') }}" >
                <label for="nama_lokasi">Nama Lokasi</label>
                @error('nama_lokasi')
                    <div class="invalid-feedback">
                        {{ $message }}
                    </div>
                @enderror
            </div>
            <button class="w-100 btn btn-lg btn-warning" type="submit">Buat Data Lokasi</button>
        </form>
        </div>
    </div>

</div>

<div class="row">
    <div class="p-3 card col-md-6">
        <div class="card-header bg-info">
          <h5 class="card-title text-center text-white"> Daftar Lemari</h5>
        </div>
    <div class="card-body ">
        <table  class="table " style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Lemari</th>
                        <th>Lokasi</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ( $lemari as $ls)
                   <tr>
                        <td>{{ $loop->iteration  }}</td>
                        <td>{{ $ls->nama_lemari }}</td>
                        <td>{{ $ls->lokasi->nama_lokasi }}</td>
                        <td>
                            <a href="" class="badge bg-info"><span data-feather="edit"></span></a>
                            <a href="" class="badge bg-danger"><span data-feather="x-circle"></span></a>

                        </td>
                    </tr>
                    @endforeach
                </tbody>
        </table>
    </div>
    </div>
    <div class="p-3 card col-md-6">
        <div class="card-header bg-warning">
          <h5 class="card-title text-center text-white"> Daftar Lokasi</h5>
        </div>
    <div class="card-body ">
        <table class="table" style="width:100%">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Lokasi</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($location as $loc)
                    <tr>
                        <td>{{ $loop->iteration  }}</td>
                        <td>{{ $loc->nama_lokasi }}</td>
                        <td>
                            <a href="" class="badge bg-info"><span data-feather="edit"></span></a>
                            <a href="" class="badge bg-danger"><span data-feather="x-circle"></span></a>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
        </table>
    </div>
    </div>
</div>


@endsection
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script>

