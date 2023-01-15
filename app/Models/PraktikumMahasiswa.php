<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PraktikumMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'praktikum_mahasiswa';
    protected $primaryKey = 'id_praktikum_mahasiswa';
    protected $guarded = [];


    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id','id_mahasiswa');
    }

    public function praktikum()
    {
        return $this->belongsTo(Praktikum::class, 'praktikum_id', 'id_praktikum');
    }

    public function kelompok ()
    {
        return $this->belongsTo(Kelompok::class,'kelompok_id','id_kelompok');
    }
}
