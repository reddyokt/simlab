<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lokasi extends Model
{
    use HasFactory;

    protected $table = 'lokasi';
    protected $fillable = ['id_lokasi', 'nama_lokasi'];
    protected $guarded ='id_lokasi';

    public function bahan()
    {
        return $this->hasMany(Bahan::class, 'lokasi_id', 'id_lokasi');
    }

    public function lemari()
    {
        return $this->hasMany(Lemari::class,'id_lokasi', 'id_lokasi');
    }
}
