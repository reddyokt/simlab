<?php

namespace App\Imports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use App\Models\Mahasiswa;
use App\Models\PraktikumMahasiswa;
use App\Models\Kelas;
use App\Models\Praktikum;

class PraktikanImport implements ToCollection,WithHeadingRow
{

    private $periode_id;
    public function __construct($periode_id)
    {
        $this->periode_id=$periode_id;
    }

    public function collection(Collection $collection)
    {
        //dd($collection->toArray());
        foreach($collection as $row) {

            $mhs = Mahasiswa::updateOrcreate(
                ['nim'=>$row['nim']],
                ['nama_mahasiswa'=>$row['nama_mahasiswa']]
            );

            $praktikum = Praktikum::with(['kelas','periode'])
            ->whereHas('kelas',function($q)use($row){
                $q->where('kode_kelas',$row['kode_kelas']);
                })
            ->where('periode_id',$this->periode_id)
            ->first();
           //dd($praktikum);
            PraktikumMahasiswa::create([
                'mahasiswa_id'=> $mhs->id_mahasiswa,
                'praktikum_id'=> $praktikum->id_praktikum
            ]);
        }

    }

}
