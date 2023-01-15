<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pengumuman extends Model
{
    use HasFactory;

    protected $table = 'pengumuman';
    protected $fillable = ['judul_pengumuman','uraian_pengumuman','image'];
    protected $primaryKey ='id_pengumuman';

}
