<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;
    protected $table = 'tugas';
    protected $fillable =  ['id_tugas','modul_id','jenis_tugas','uraian_tugas','is_active','is_validated','delete_at'];
    protected $primaryKey = 'id_tugas';


    public function modul()
    {
        return $this->belongsTo(Modul::class,'modul_id', 'id_modul' );
    }

    public function jawabantugas()
    {
        return $this->hasMany(JawabanTugas::class, 'tugas_id', 'id_tugas');
    }
}
