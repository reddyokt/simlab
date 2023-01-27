<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dosen extends Model
{
    protected $guarded = ['id_dosen'];

    protected $table = 'dosen';
    protected $fillable =['id_dosen','user_id','nama_dosen','nidn'];
    protected $primaryKey = 'id_dosen';
}
