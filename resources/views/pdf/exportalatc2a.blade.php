<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Data Alat Praktikum C2A</title>
    <style>
        table, th, td {
          border: 1px solid #666;
        }
      </style>

</head>
<body>
    <img class="text-center" src="{{asset('img/simlab.png')}}" alt="" width="20%">
    <h5 class="text-center mt-2">Data Alat Praktikum C2A</h5>
    <table id="example1" class="table table-striped table-fixed"  style="width:100%; font-size:12px;">
        <thead>
            <tr>
                <th style="font-size:12px">#</th>
                <th style="font-size:12px">Nama Alat</th>
                <th style="font-size:12px">Merk</th>
                <th style="font-size:12px">Ukuran</th>
                <th style="font-size:12px">Jumlah</th>
                <th style="font-size:12px">Lokasi</th>
            </tr>
        </thead>
        <tbody>

        @foreach ($c2a as $a )

        <tr>
            <td>{{ $loop->iteration }}</td>
            <td style="font-size:12px">{{ $a->nama_alat }}</td>
            <td style="font-size:12px">{{ $a->merk }}</td>
            <td style="font-size:12px">{{ $a->ukuran }}</td>
            <td style="font-size:12px">{{ $a->jumlah }}</td>
            <td style="font-size:12px"> {{ $a->nama_lokasi }} <br>Lemari : {{ $a->nama_lemari }}.{{ $a->baris }}.{{ $a->kolom }}</td>
        </tr>
        @endforeach
        </tbody>
    </table>

    <p class="text-muted mt-2" style="font-size: 12px;">Data Diambil pada   {{ (\Carbon\Carbon::now())->toDateTimeString() }} oleh {{ auth()->user()->nama_lengkap }}</p>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

</body>
</html>
