<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianSubjektif extends Model
{
    use HasFactory;

    protected $table = 'penilaian_subjektif';
    protected $primaryKey = 'id_penilaian';
    protected $guarded = [];

    public function modul()
    {
        return $this->belongsTo(Modul::class, 'modul_id', 'id_modul');
    }
}
