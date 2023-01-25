<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JawabanUjian extends Model
{
    use HasFactory;

    protected $table = 'jawaban_ujian';
    protected $primaryKey = 'id_jawaban_ujian';
    protected $guarded = [];

    public function ujian()
    {
        return $this->belongsTo(Ujian::class, 'ujian_id', 'id_ujian');
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class, 'mahasiswa_id', 'id_mahasiswa');
    }

}
