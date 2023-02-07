<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membermodul extends Model
{
    use HasFactory;

    protected $table = 'membermodul';
    protected $guarded=[];

    public function member()
    {
        return $this->belongsTo(Modul::class, 'modul_id','id_modul');
    }

    public function alatmember()
    {
        return $this->belongsTo(AlatPraktikum::class, 'alat_id','id_alat_praktikum');
    }

       public function bahan()
    {
        return $this->belongsTo(Bahan::class,'bahan_id', 'id_bahan');
    }

    public function alat()
    {
        return $this->belongsTo(AlatPraktikum::class,'alat_id', 'id_alat_praktikum');
    }
}
