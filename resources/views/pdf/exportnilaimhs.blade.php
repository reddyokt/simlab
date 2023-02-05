<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Detail Nilai Praktikum {{ auth()->user()->mahasiswa->nama_mahasiswa }}</title>

    <style>
        table, tr, th, td {
          border: 1px solid black;
          border-collapse: collapse;
        }
    </style>

</head>

</head>
<body>
    <div>
        <img class="text-align: center;" src="{{asset('img/simlab.png')}}" alt="" width="20%">
        <h5 class="mt-2 text-center">Data Nilai {{ auth()->user()->mahasiswa->nama_mahasiswa }}</h5>
    </div>
    <div class="mt-5">
        <table id="example" class="table">
            <thead>
                <tr>
                    <td style="text-align: center; borde:1px;" colspan="6"><b>{{ $praktikum->nama_kelas }} - {{ $praktikum->kelas->nama_kelas }} <b></td>
                </tr>
                <tr>
                    <th style="text-align: center;">#</th>
                    <th>Nama Modul</th>
                    <th style="text-align: center;">Pre Test</th>
                    <th style="text-align: center;">Post Test</th>
                    <th style="text-align: center;">Subjektif</th>
                    <th style="text-align: center;">Laporan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ( $praktikum->modul as $modul )
                @php
                    $nilaipretest=null;


                    $x = $modul->tugas->where("jenis_tugas", 'Pre Test')->first();
                    if($x){
                        $nilaipretest = $x->jawabantugas->where("mahasiswa_id", auth()->user()->mahasiswa->id_mahasiswa)->first();
                    }

                    if($nilaipretest){
                        $nilaipretest = $nilaipretest->nilaitugas;
                    }


                    $nilaiposttest=null;

                    $x = $modul->tugas->where("jenis_tugas", 'Post Test')->first();
                    if($x){
                        $nilaiposttest = $x->jawabantugas->where("mahasiswa_id", auth()->user()->mahasiswa->id_mahasiswa)->first();
                    }

                    if($nilaiposttest){
                        $nilaiposttest = $nilaiposttest->nilaitugas;
                    }

                    $nilailaporan=null;

                    $x = $modul->tugas->where("jenis_tugas", 'Laporan')->first();
                    if($x){
                        $nilailaporan = $x->jawabantugas->where("mahasiswa_id", auth()->user()->mahasiswa->id_mahasiswa)->first();
                    }

                    if($nilailaporan){
                        $nilailaporan = $nilailaporan->nilaitugas;
                    }

                    $nilaisub = \App\Models\PenilaianSubjektif::query()->where('mahasiswa_id', auth()->user()->mahasiswa->id_mahasiswa)
                                                                    ->where('modul_id', $modul->id_modul)->first();

                     if($nilaisub) {
                        $nilaisub = $nilaisub->nilaisubjektif;
                     }
                @endphp

                <tr>
                    <td style="text-align: center;">{{ $loop->iteration  }}</td>
                    <td>{{ $modul->nama_modul }}</td>
                    <td style="text-align: center;">{{ $nilaipretest ? "$nilaipretest" : "Belum dinilai" }}</td>
                    <td style="text-align: center;">{{ $nilaiposttest ? "$nilaiposttest" : "Belum dinilai" }}</td>
                    <td style="text-align: center;">{{ $nilaisub ? "$nilaisub" : "Belum dinilai" }}</td>
                    <td style="text-align: center;">{{ $nilailaporan ? "$nilailaporan" : "Belum dinilai" }}</td>
                </tr>
                @endforeach
                <tr>
                    <th rowspan="2"></th>
                    <th style="text-align: center;">Ujian Awal</th>
                    <th colspan="2" style="text-align: center;">Ujian Akhir</th>
                    <th colspan="2" style="text-align: center;">Ujian Lisan</th>
                </tr>
                <tr>

                    <td style="text-align: center;">{{ $ujianawal ? "$ujianawal" : "Belum dinilai"  }}</td>
                    <td colspan="2" style="text-align: center;">{{ $ujiakhir ? "$ujiakhir" : "Belum dinilai"  }}</td>
                    <td colspan="2" style="text-align: center;">{{ $ujianlisan ? "$ujianlisan" : "Belum dinilai" }}</td>
                </tr>
                <tr>
                    <td style="text-align: right; padding: 0 10 0 0;" colspan="5"><b>Nilai Akhir<b></td>
                    <td style="text-align: center;"><b>{{ $nilaiakhir ? "$nilaiakhir" : "Belum dinilai" }}<b></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>



