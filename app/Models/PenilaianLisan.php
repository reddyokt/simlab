<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianLisan extends Model
{
    use HasFactory;

    protected $table = 'penilaian_ujian_lisan';
    protected $primaryKey = 'id_penilaian_ujian_lisan';
    protected $guarded = [];

    public function praktikum()
    {
        return $this->belongsTo(Praktikum::class, 'praktikum_id', 'id_praktikum');
    }

}
