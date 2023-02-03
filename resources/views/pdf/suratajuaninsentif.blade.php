<html>
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
<title>Surat Ajuan Insentif</title>

</head>
<body>
<table class="table w-100">
    <tr>
        <td>
            <div class="text-center"><img src="{{asset('img/logo-bulat-umj.png')}}" style="width: 60px;"> <h4> Surat Ajuan Insentif Publikasi</h4></div>
        </td>
    </tr>
</table>
<hr>

<table class="table w-100" >
    <tr>
        <td> Kepada Yth 	: Rektor UMJ </td>
    </tr>
    <tr>
        <td> Perihal 		: Pengajuan Insentif Publikasi (${jenis_publikasi})</td>
    </tr>
    <tr>
        <td> No 		: ${nomor}/${bulan}/${tahun}/Insentif Publikasi/LPPM-UMJ</td>
    </tr>
    <br><br>
    <tr>
        <td> Assalamu’alaikum Warahmatullahi Wabarakatuh <br>
            Berdasarkan hasil kegiatan Catur Dharma di Universitas Muhammadiyah Jakarta, maka saya :
            </td>
    </tr>
</table>
<table class="table table-bordered align-item-start" style="border: 1px solid black;">
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black;">Nama</td>
        <td style="border: 1px solid black;">: ${nama} </td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black;">NIDN</td>
        <td style="border: 1px solid black;">: ${nidn} </td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black;">Fakultas</td>
        <td style="border: 1px solid black;">: ${fakultas} </td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black;">Program Studi</td>
        <td style="border: 1px solid black;">: ${prodi} </td>
    </tr>
</table>
<table>
    <tr>
        <td> Mengajukan insentif berdasarkan Standar Biaya Umum yang berlaku untuk karya sebagai berikut </td>
    </tr>
</table>
<table class="table table-bordered align-item-start" style="border: 1px solid black;">
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black;">Jenis Publikasi</td>
        <td style="border: 1px solid black;">: ${jenis_publikasi} </td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black;">Judul</td>
        <td style="border: 1px solid black;">: ${judul} </td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black;">Jurnal</td>
        <td style="border: 1px solid black;">: ${jurnal} </td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black;">Peran Penulis</td>
        <td style="border: 1px solid black;">: ${peran_penulis} </td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black;">Tautan ke Artikel Jurnal</td>
        <td style="border: 1px solid black;">: ${tautan_artikel_jurnal} </td>
    </tr>
</table>
<table>
    <tr>
        <td>Demikian Pengajuan kami, dan semoga dapat diproses sebagaimana mestinya. Kami ucapkan terima kasih.</td>
        <td>Wassalamualaikum Warahmatullahi Wabarakatuh.</td>
    </tr>
</table>
<table class="table table-bordered align-item-start" style="border: 1px solid black;">
    <tr class="text-center" style="border: 1px solid black;">
        <td style="border: 1px solid black;">Dekan</td>
        <td style="border: 1px solid black;">Ketua Program Studi</td>
        <td style="border: 1px solid black;">Pengusul</td>
    </tr>
    <tr style="border: 1px solid black;">
        <td style="border: 1px solid black; height:100px;"></td>
        <td style="border: 1px solid black;"></td>
        <td style="border: 1px solid black;"></td>
    </tr>
    <tr class="text-center" style="border: 1px solid black;">
        <td style="border: 1px solid black;">${nama_dekan}</td>
        <td style="border: 1px solid black;">_____________</td>
        <td style="border: 1px solid black;">${nama}</td>
    </tr>
</table>
<br><br><br><br><br>
<table>
<tr>
    <td> <p class="text-muted mt-2" style="font-size: 12px;">diunduh pada   {{ (\Carbon\Carbon::now())->toDateTimeString() }}</p> </td>
</tr>
</table>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>

