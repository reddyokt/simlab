<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Export Peserta Praktikum Periode {{ $periode->tahun_ajaran }} - {{ $periode->semester }}</title>

    <style>
        table, th, td {
          border: 1px solid #666;
        }
      </style>
</head>
<body>
    <img class="text-center" src="{{asset('img/simlab.png')}}" alt="" width="20%">
    <h5 class="text-center mt-2">Kelompok Praktikum Periode {{ $periode->tahun_ajaran }} - {{ $periode->semester }}</h5>
    <div>
    <table id="example" class="display" style="width:100%; font-size:12px;">
        <thead>
            <tr>
                <th>#</th>
                <th>Kelompok</th>
                <th>Nama Kelas</th>
                <th>Nama Mahasiswa</th>
                <th>NIM</th>
            </tr>
        </thead>
        <tbody>
            @foreach ( $datakelompok as $mhs )
            <tr>
                <td>{{ $loop->iteration  }}</td>
                <td>{{ $mhs->kelompok->nama_kelompok }}</td>
                <td>{{ $mhs->kelompok->praktikum->kelas->nama_kelas }}</td>
                <td>{{ $mhs->mahasiswa->nama_mahasiswa }}</td>
                <td>{{ $mhs->mahasiswa->nim }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
    </div>

    <p class="text-muted mt-2" style="font-size: 12px;">Data Diambil pada   {{ (\Carbon\Carbon::now())->toDateTimeString() }} oleh {{ auth()->user()->nama_lengkap }}</p>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
