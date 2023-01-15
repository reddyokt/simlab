<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokMhs extends Model
{
    use HasFactory;

    protected $table = 'kelompok_mhs';
    protected $primaryKey = 'id_kelompokMhs';
    protected $guarded =[];

    public function kelompok ()
    {
        return $this->belongsTo(Kelompok::class, 'kelompok_id','id_kelompok');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id_mahasiswa');
    }

}
