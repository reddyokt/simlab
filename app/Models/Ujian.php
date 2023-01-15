<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ujian extends Model
{
    use HasFactory;
    protected $table = 'ujian';
    protected $fillable =  ['id_ujian','kelas_id','uraian_ujian'];
    protected $primaryKey = 'id_ujian';
}
