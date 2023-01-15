<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelompok extends Model
{
    use HasFactory;

    protected $table = 'kelompok';
    protected $primaryKey = 'id_kelompok';
    protected $fillable = ['periode_id','praktikum_id','nama_kelompok'];

    public function mahasiswas()
    {
        return $this->belongsToMany(Mahasiswa::class, 'kelompok_mhs', 'kelompok_id' , 'mahasiswa_id');
    }

    public function praktikum()
    {
        return $this->belongsTo(Praktikum::class, 'praktikum_id', 'id_praktikum');
    }

}
