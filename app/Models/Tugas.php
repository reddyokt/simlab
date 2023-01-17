<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;
    protected $table = 'tugas';
    protected $fillable =  ['id_tugas','modul_id','jenis_tugas','uraian_tugas','is_active','is_validated'];
    protected $primaryKey = 'id_tugas';

    public  function tugas()
    {
        return $this->hasMany(Modul::class, 'id_modul', 'modul_id');
    }
}
