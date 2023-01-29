<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Data Alat Praktikum C2B</title>
    <style>
        table, th, td {
          border: 1px solid #666;
        }
      </style>
</head>
<body>
    <img class="text-center" src="{{asset('img/simlab.png')}}" alt="" width="20%">
    <h5 class="text-center mx-auto mt-2">Data Alat Praktikum C2B</h5>
    <table id="example2" class="table table-striped table-fixed" style="width:100%; font-size:12px;" >
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
            @foreach ( $c2b as $b )
            <tr>
                <td style="font-size:12px">{{ $loop->iteration  }}</td>
                <td style="font-size:12px">{{ $b->nama_alat }}</td>
                <td style="font-size:12px">{{ $b->merk }}</td>
                <td style="font-size:12px">{{ $b->ukuran }}</td>
                <td style="font-size:12px">{{ $b->jumlah }}</td>
                <td style="font-size:12px">{{ $b->nama_lokasi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p class="align-items-end" style="font-size:12px;" >Data diambil pada : {{ (\Carbon\Carbon::now())->toDateTimeString() }}</p>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
