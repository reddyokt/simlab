<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bahan extends Model
{
    use HasFactory;

    protected $table = 'bahan';
    protected $primaryKey = 'id_bahan';
    protected $fillable = ['id_bahan', 'nama_bahan','rumus', 'jumlah', 'lokasi_id','created_at',
                            'updated_at'];

    public function memberbahan()
    {
        return $this->belongsTo(Membermodul::class, 'id_bahan', 'bahan_id');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class,'lokasi_id', 'id_lokasi');
    }

}

