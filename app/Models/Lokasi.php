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
        return $this->hasMany(Bahan::class, 'id_lokasi', 'lokasi_id');
    }
}
