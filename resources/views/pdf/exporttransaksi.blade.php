<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Export Transaksi Penggunaan Alat dan Bahan Modul Praktikum</title>

    <style>
        table, th, td {
          border: 1px solid #666;
        }
    </style>
</head>
<body>
    <img class="text-center" src="{{asset('img/simlab.png')}}" alt="" width="20%">
    <h5 class="text-center mt-2">Transaksi Penggunaan Alat dan Bahan Modul Praktikum</h5>
    <table id="example1" class="table table-striped table-fixed" style="width:100%; font-size:12px;">
        <thead>
            <tr>
                <th style="font-size:12px">#</th>
                <th style="font-size:12px">Nama Kelas - Modul</th>
                <th style="font-size:12px">Alat Dipakai</th>
                <th style="font-size:12px">Bahan Dipakai</th>
                <th style="font-size:12px">Catatan Praktikum</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($data as $dt )
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td style="font-size:12px">{{$dt->praktikum->kelas->nama_kelas }} - {{$dt->nama_modul }}</td>

            <td style="font-size:12px">
                @foreach ($dt->alat as $member)
                {{ $member->nama_alat }} - {{ $member->ukuran }}<br>
                @endforeach
            </td>
            <td style="font-size:12px">
                @foreach ($dt->bahan as $member)
                {{ $member->nama_bahan }} - {{ $member->pivot->jumlah_bahan }}<br>
                @endforeach
            </td>
            {{-- @dd($dt->catatan->toArray()) --}}
            <td style="font-size:12px">
                {!! $dt->catatan->isi_catatan  !!}
            </td>
        @endforeach
        </tbody>
    </table>

    <p style="font-size:12px">{{ (\Carbon\Carbon::now())->toDateTimeString() }}</p>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>
