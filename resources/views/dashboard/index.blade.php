@extends('dashboard.layouts.main')


@section('container')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Assalamu'alaikum {{ auth()->user()->username }}</h1>
</div>

<div class="card">
    <div class="card-header">
      Daftar Praktikan Menunggu Persetujuan
    </div>
    <div class="card-body">
        <table id="example" class="table table-borderless" style="width:100%">
            <thead class="thead-light">
                <tr>
                    <th>#</th>
                    <th>Nama Mahasiswa</th>
                    <th>NIM</th>
                    <th>Praktikum Dipilih</th>
                    <th class="dblock text-center">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dataMhs as $key=>$d)

                <tr>
                    <td>{{ $loop->iteration  }}</td>
                    <td>{{ $d->nama_mahasiswa}}</td>
                    <td>{{ $d->nim }}</td>
                    <td>{{ $d->nama_kelas }}</td>
                    <td class="dblock text-center">
                        <div class="row text-center">
                            <form action="/setuju/{{ $d->id_pendaftaran }}" method="POST" class="row text-center mx-auto">
                                @csrf
                                <div class="col-md-7">
                                    <select class="form-control" name="status" id="status" required value="{{ old ('status') }}" style="font-size:12px;">
                                        <option selected disabled>Belum divalidasi</option>
                                        <option select value ="Diterima">Diterima</option>
                                        <option select value ="Ditolak">Ditolak</option>
                                    </select>
                                </div>
                                <div class="col-md-1">
                                    <button class="btn btn-md btn-primary" type="submit">SIMPAN</button>
                                </div>
                            </form>

                        </div>
                    </td>
                </tr>

                @endforeach
            </tbody>
        </table>
    </div>
  </div>

@endsection


