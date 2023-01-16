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
        return $this->belongsTo(Praktikum::class, 'kelas_id', 'id_praktikum');
    }

    public  function membermodul()
    {
        return $this->belongsTo(Membermodul::class, 'id_modul', 'modul_id');
    }

    public function alat()
    {
        return $this->belongsToMany(Alats::class, 'membermodul','modul_id', 'alat_id');
    }

    public function bahan()
    {
        return $this->belongsToMany(Bahan::class, 'membermodul','modul_id', 'bahan_id');
    }



}
