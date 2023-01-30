<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Export Absen Peserta Praktikum</title>

    <style>
        table, th, td {
          border: 1px solid #666;
        }
      </style>
</head>

<body>
    <img class="text-center" src="{{asset('img/simlab.png')}}" alt="" width="20%">
    <h5 class="text-center mt-2">Absensi Peserta Praktikum</h5>
    <div>
        <table id="example" class="display" style="width:100%; font-size:12px;">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nama Kelas</th>
                    <th>Nama Modul</th>
                    <th>NIM</th>
                    <th>Nama Mahasiswa</th>
                    <th>Absen</th>
                </tr>
            </thead>
            <tbody>
                @foreach ( $praktikum->modul as $modul )
                    @foreach ($praktikumMhs as $pm )
                        @php
                            $isHadir = $data->where('modul_id',$modul->id_modul)
                                            ->where('mahasiswa_id',$pm->mahasiswa_id)
                                            ->count() ? "Hadir" : "Tidak Hadir"
                        @endphp
                        <tr>
                            <td>{{ $loop->iteration  }}</td>
                            <td>{{$pm->praktikum->kelas->nama_kelas}}</td>
                            <td>{{$modul->nama_modul}}</td>
                            <td>{{$pm->mahasiswa->nim}}</td>
                            <td>{{$pm->mahasiswa->nama_mahasiswa}}</td>
                            <td>{{$isHadir }}</td>
                        </tr>

                    @endforeach

                @endforeach
            </tbody>
        </table>

    </div>

    <p class="text-muted mt-2" style="font-size: 12px;">Data Diambil pada   {{ (\Carbon\Carbon::now())->toDateTimeString() }} oleh {{ auth()->user()->nama_lengkap }}</p>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>