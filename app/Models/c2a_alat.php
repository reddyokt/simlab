<?php

namespace App\Models;

use App\Models\Lemari;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class c2a_alat extends Model
{
    use HasFactory;
    protected $table ='c2a_alat';
    protected $fillable =['id_alat_c2a','nama_alat_c2a','merk','ukuran','jumlah','rusak','lemari_id','kolom','baris'];
    protected $primaryKey ='id_alat_c2a';

    public function lemari()
    {
        return $this->belongsTo(Lemari::class, 'lemari_id');
    }

}
