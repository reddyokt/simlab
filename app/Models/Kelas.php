<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    use HasFactory;
    protected $table = 'kelas';
    protected $primaryKey = 'id_kelas';

    public function praktikum()
    {
        return $this->hasMany(Praktikum::class,'kelas_id','id_kelas');
    }
}
