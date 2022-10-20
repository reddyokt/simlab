<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alats extends Model
{
    use HasFactory;
    protected $table = 'alat';
    protected $primaryKey = 'id_alat';
    protected $fillable = ['id_alat', 'nama_alat','merk', 'ukuran', 'jumlah', 'pabrikan', 'jenis',
                            'lokasi_id', 'lemari_id', 'kolom', 'baris', 'rusak', 'created_at',
                            'updated_at'];


    public function lemari()
    {
        return $this->belongsTo(Lemari::class, 'lemari_id');
    }

    public function memberalat()
    {
        return $this->belongsTo(Membermodul::class, 'id_alat', 'alat_id');
    }
}
