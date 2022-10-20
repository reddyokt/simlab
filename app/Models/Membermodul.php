<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Membermodul extends Model
{
    use HasFactory;

    protected $table = 'membermodul';
    protected $fillable = ['modul_id','alat_id'];

    public function member(){
        return $this->belongsTo(Modul::class, 'modul_id','id_modul');
    }

    public function alatmember(){
        return $this->belongsTo(Alats::class, 'alat_id','id_alat');
    }
}
