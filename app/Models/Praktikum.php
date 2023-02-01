<?php

namespace App\Models;

use App\Models\Dosen;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Praktikum extends Model

{
    protected $table = 'praktikum';
    protected $primaryKey = 'id_praktikum';
    protected $fillable = ['id_praktikum','periode_id','kelas_id','dosen_id','nama_kelas','asisten_id'];

   public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id','id_dosen' );
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id','id_kelas' );
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id', 'id_periode');
    }

    public function mahasiswa()
    {
        return $this->belongsToMany(Mahasiswa::class, 'praktikum_mahasiswa', 'praktikum_id','mahasiswa_id','id_praktikum', 'id_mahasiswa');
    }

    public function newmahasiswa()
    {
        return $this->belongsToMany(NewMahasiswa::class, 'praktikum_mahasiswa', 'praktikum_id','mahasiswa_id','id_praktikum', 'id_mahasiswa');
    }

    public function modul()
    {
        return $this->hasMany(Modul::class, 'praktikum_id','id_praktikum');
    }

    public function ujian()
    {
        return $this->hasMany(Ujian::class, 'praktikum_id','id_praktikum');
    }

    public function asisten()
    {
        return $this->belongsTo(User::class, 'asisten_id' , 'id');
    }
}

