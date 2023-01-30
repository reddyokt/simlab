<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Data Barang Umum</title>
    <style>
        table, th, td {
          border: 1px solid #666;
        }
      </style>

</head>
<body>
    <img class="text-center" src="{{asset('img/simlab.png')}}" alt="" width="20%">
    <h5 class="text-center mt-2">Data Barang Umum</h5>
<div class="dblock mx-auto text-center">
    <table id="example" class="display table table-striped" style="width:100% font-size:12px">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama</th>
                <th>Merk</th>
                <th>Ukuran</th>
                <th>Pabrikan</th>
                <th>Jumlah/Kondisi</th>
                 <th>Lokasi</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($barang as $b )
                  <tr>
                <td>{{ $loop->iteration  }}</td>
                <td>{{ $b->nama_barang }}</td>
                <td>{{ $b->merk_barang }}</td>
                <td>{{ $b->ukuran_barang }}</td>
                <td>{{ $b->pabrik_barang }}</td>
                <td>Jumlah : {{ $b->jumlah_barang }} <br> Rusak : {{ $b->barang_rusak }} </td>
                <td>{{ $b->lokasi->nama_lokasi }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<p class="text-muted mt-2" style="font-size: 12px;">Data Diambil pada   {{ (\Carbon\Carbon::now())->toDateTimeString() }} oleh {{ auth()->user()->nama_lengkap }}</p>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
