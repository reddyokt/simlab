<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    use HasFactory;
    protected $table = 'ujian';
    protected $primaryKey = 'id_ujian';
    protected $guarded =[];

    public function praktikum()
    {
        return $this->belongsTo(Praktikum::class, 'praktikum_id','id_praktikum');
    }
}
