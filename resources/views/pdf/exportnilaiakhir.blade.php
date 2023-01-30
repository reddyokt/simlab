<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Export Nilai Akhir {{ $praktikum->kelas->nama_kelas }} {{ $praktikum->periode->tahun_ajaran }}</title>

    <style>
        table, th, td {
          border: 1px solid #666;
        }
      </style>
</head>
<body>
    <img class="text-center" src="{{asset('img/simlab.png')}}" alt="" width="20%">
    <h5 class="text-center mt-2">Nilai Akhir {{ $praktikum->kelas->nama_kelas }} {{ $praktikum->periode->tahun_ajaran }}</h5>
    <table class="table table-striped table-fixed" >
        <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Nama Mahasiswa</th>
                <th scope="col">Kelas Praktikum</th>
                {{-- <th scope="col">Nilai Praktikum (50%)</th>
                <th scope="col">Nilai Laporan (20%)</th>
                <th scope="col">Nilai Ujian Awal (10%)</th>
                <th scope="col">Nilai Ujian Akhir (10%)</th>
                <th scope="col">Nilai Ujian Lisan (10%)</th> --}}
                <th scope="col">Nilai Akhir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ( $data as  $dt)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $dt->mahasiswa->nama_mahasiswa}}</td>
                <td>{{ $dt->praktikum->kelas->nama_kelas}}</td>
                <td>{{ $dt->nilaiakhir }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ (\Carbon\Carbon::now())->toDateTimeString() }}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
