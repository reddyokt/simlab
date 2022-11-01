<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KelompokMhs extends Model
{
    use HasFactory;

    protected $table = 'kelompok_mhs';
    protected $primaryKey = 'id_kelompokMhs';
    protected $fillable = ['kelompok_id','mahasiswa_id','periode_id','modul_id'];
}
