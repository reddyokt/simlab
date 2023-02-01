<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Periode extends Model
{
    use HasFactory;
    protected $table = 'periode';
    protected $primaryKey = 'id_periode';
    protected $fillable = ['id_periode', 'tahun_ajaran', 'semester',
     'start_periode', 'end_periode', 'status_periode'];


}
