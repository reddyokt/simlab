<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Detail Nilai Praktikum {{ auth()->user()->mahasiswa->nama_mahasiswa }}</title>
</head>
<body>
    <div>
        <h3 class="title my-3">Data Nilai {{ auth()->user()->mahasiswa->nama_mahasiswa }}</h3>
    </div>
    <div class="mt-5">
        <table id="example" class="display table table-bordered" style="width:100%; border: 1px solid black;">
            <thead>
                <tr>
                    <td style="text-align: center;" colspan="10"><b>Nilai Praktikum Kelas A<b></td>
                </tr>
                <tr>
                    <th>#</th>
                    <th>Nama Modul</th>
                    <th>Pre Test</th>
                    <th>Post Test</th>
                    <th>Subjektif</th>
                    <th>Laporan</th>
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
                    <td>{{ $loop->iteration  }}</td>
                    <td>{{ $modul->nama_modul }}</td>
                    <td>{{ $nilaipretest }}</td>
                    <td>{{ $nilaiposttest }}</td>
                    <td>{{ $nilaisub }}</td>
                    <td>{{ $nilailaporan }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <table id="example" class="display table table-bordered" style="width:100%; border: 1px solid black;">
            <tbody>
                <tr>
                    <th>#</th>
                    <th>Ujian Awal</th>
                    <th>Ujian Akhir</th>
                    <th>Ujian Lisan</th>
                </tr>
                <tr>
                    <td></td>
                    <td>{{ $ujianawal }}</td>
                    <td>{{ $ujiakhir }}</td>
                    <td>{{ $ujianlisan }}</td>
                </tr>
                <tr>
                    <td style="text-align: end;" colspan="9"><b>Nilai Akhir<b></td>
                    <td style="text-align:center;"><b>{{ $nilaiakhir }}<b></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>



