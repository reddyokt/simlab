<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelasMahasiswa extends Model
{
    use HasFactory;

    protected $table = 'kelas_mahasiswa';
    protected $primaryKey = 'id_kelas_mahasiswa';
    protected $guarded = ['id_kelas_mahasiswa'];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id','id_mahasiswa');
    }

    public function periode()
    {
        return $this->belongsTo(Periode::class, 'periode_id','id_periode');
    }

    public function kelas()
    {
        return $this->belongsTo(Kelas::class, 'kelas_id','id_kelas');
    }

    public function praktik()
    {
        return $this->belongsTO(Praktikum::class, 'kelas_id', 'kelas_id');
    }
}
