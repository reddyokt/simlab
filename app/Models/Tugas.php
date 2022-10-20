<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tugas extends Model
{
    use HasFactory;
    protected $table = 'tugas';
    protected $fillable =  ['id_tugas','modul_id','jenis_tugas','uraian'];
    protected $primaryKey = 'id_tugas';
}
