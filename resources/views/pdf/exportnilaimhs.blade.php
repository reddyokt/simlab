<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div>
        <h3 class="title my-3">Data Nilai</h3>
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
                <tr>
                    <td>{{ $loop->iteration  }}</td>
                    <td>{{ $modul->nama_modul }}</td>
                    <td>100</td>
                    <td>100</td>
                    <td>100</td>
                    <td>100</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        <table id="example" class="display table table-bordered" style="width:100%; border: 1px solid black;">
            <tbody>
                <tr>
                    <th>Ujian Awal</th>
                    <th>Ujian Akhir</th>
                    <th>Ujian Lisan</th>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                </tr>
                <tr>
                    <td style="text-align: end;" colspan="9"><b>Nilai Akhir<b></td>
                    <td style="text-align:center;"><b>100<b></td>
                </tr>
            </tbody>
        </table>
    </div>
</body>
</html>



