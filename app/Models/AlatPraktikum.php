<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlatPraktikum extends Model
{
    use HasFactory;

    protected $table = 'alat_praktikum';
    protected $primaryKey = 'id_alat_praktikum';
    protected $guarded = [];

    public function kategori()
    {
        return $this->hasOne(Kategorialat::class, 'id_kategori_alat', 'kategori_alat_id');
    }

    public function lemari()
    {
        return $this->belongsTo(Lemari::class,'lemari_id', 'id_lemari');
    }

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lokasi_id', 'id_lokasi');
    }

    public function memberalat()
    {
        return $this->belongsTo(Membermodul::class, 'id_alat_praktikum', 'alat_id');
    }
}
