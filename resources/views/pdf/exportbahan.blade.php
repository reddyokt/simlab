<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <title>Data Bahan Praktikum</title>
    <style>
        table, th, td {
          border: 1px solid #666;
        }
      </style>

</head>
<body>
    <img class="text-center" src="{{asset('img/simlab.png')}}" alt="" width="20%">
    <h5 class="text-center mt-2">Data Bahan Praktikum</h5>
<div class="dblock mx-auto text-center">
    <table class="table table-responsive w-100" id="example" class="display" style="width:100% font-size:12px">
        <thead>
            <tr>
                <th style="font-size:12px">#</th>
                <th style="font-size:12px">Nama Bahan</th>
                <th style="font-size:12px">Rumus Kimia</th>
                <th style="font-size:12px">Lokasi</th>
                <th style="font-size:12px">Jumlah</th>
            </tr>
        </thead>
        <tbody>
        @foreach ($bahan as $b )

        <tr>
            <td style="font-size:12px">{{ $loop->iteration }}</td>
            <td style="font-size:12px">{{ $b->nama_bahan }}</td>
            <td style="font-size:12px">{{ $b->rumus }}</td>
            <td style="font-size:12px">{{ $b->lokasi_id }}</td>
            <td style="font-size:12px">{{ $b->jumlah }}</td>
        </tr>

        @endforeach
        </tbody>
    </table>
</div>







<p class="text-muted mt-2" style="font-size: 12px;">Data Diambil pada   {{ (\Carbon\Carbon::now())->toDateTimeString() }} oleh {{ auth()->user()->nama_lengkap }}</p>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

</body>
</html>
