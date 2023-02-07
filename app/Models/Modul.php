<?php

namespace App\Models;

use App\Models\Alats;
use App\Models\Dosen;
use App\Models\Praktikum;
use App\Models\Membermodul;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Modul extends Model
{
    use HasFactory;

    protected $table = 'modul';
    protected $fillable = ['id_modul', 'nama_modul','kelas_id','tanggal_praktek'];
    protected $primaryKey = 'id_modul';

    public  function kelas()
    {
        return $this->belongsTo(Praktikum::class, 'praktikum_id', 'id_praktikum');
    }

    public  function membermodul()
    {
        return $this->hasMany(Membermodul::class, 'modul_id', 'id_modul');
    }

    public function alat()
    {
        return $this->belongsToMany(AlatPraktikum::class, 'membermodul','modul_id', 'alat_id')->where('alat_id','!=',0)->withPivot("jumlah_bahan");
    }

    public function bahan()
    {
        return $this->belongsToMany(Bahan::class, 'membermodul','modul_id', 'bahan_id')->where('bahan_id','!=',0)->withPivot("jumlah_bahan");
    }

    public function praktikum()
    {
        return $this->belongsTo(Praktikum::class, 'praktikum_id', 'id_praktikum');
    }

    public function tugas()
    {
        return $this->hasMany(Tugas::class, 'modul_id', 'id_modul');
    }

    public function catatan()
    {
        return $this->hasOne(CatatanModul::class, 'modul_id', 'id_modul');
    }


}
