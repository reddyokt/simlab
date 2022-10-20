<?php

namespace App\Models;

use App\Models\Dosen;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Praktikum extends Model

{
    protected $table = 'praktikum';
    protected $primaryKey = 'id_praktikum';
    protected $fillable = ['id_praktikum','periode_id','nama_kelas','dosen_id','modul','is_active'];

   public function dosen()
    {
        return $this->belongsTo(Dosen::class, 'dosen_id','id_dosen' );
    }


    public function practice()
    {
        return $this->belongsTo(Periode::class, 'periode_id', 'id_periode');
    }
}
