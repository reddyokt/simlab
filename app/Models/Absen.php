<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Absen extends Model
{
    use HasFactory;

    protected $table ='absen';
    protected $primaryKey = 'id_absen';
    protected $guarded = [];

    public function mahasiswa ()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id_mahasiswa');
    }

    public function modul ()
    {
        return $this->belongsTo(Modul::class, 'modul_id' , 'id_modul');
    }

}
