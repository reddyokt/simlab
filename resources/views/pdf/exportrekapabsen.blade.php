<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Export Rekap Absen</title>

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
                    <th colspan="3" style="text-align: center">{{ $praktikum->nama_kelas }} {{ $praktikum->kelas->nama_kelas }}</th>
                </tr>
                <tr>
                    <th colspan="3" style="text-align: center">{{ $data->mahasiswa->nama_mahasiswa }}</th>
                </tr>
                <tr>
                    <th width="10" style="text-align: center">#</th>
                    <th width="70">Nama Modul</th>
                    <th width="20" style="text-align: center">Absen</th>
                </tr>
            </thead>
            <tbody>
                @foreach ( $praktikum->modul as $modul )
                         <tr>
                            <td width="10" style="text-align: center">{{ $loop->iteration  }}</td>
                            <td width="70">{{ $modul->nama_modul }}</td>
                            <td width="20" style="text-align: center;">{{ $absen->contains("modul_id", $modul->id_modul) ? "Hadir" : "Tidak Hadir"}}</td>
                        </tr>

                @endforeach
                        <tr>
                            <td colspan="2" style="text-align: right; padding: 0 10 0 0;">Total hadir</td>
                            <td style="text-align: center">  {{ $absen->count() }}</td>
                        </tr>
            </tbody>
        </table>

    </div>

    <p class="text-muted mt-2" style="font-size: 12px;">Data Diambil pada   {{ (\Carbon\Carbon::now())->toDateTimeString() }} oleh {{ auth()->user()->nama_lengkap }}</p>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
