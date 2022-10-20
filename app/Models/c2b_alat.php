<?php

namespace App\Models;

use App\Models\Lokasi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class c2b_alat extends Model
{
    use HasFactory;
    protected $table ='c2b_alat';
    protected $fillable =['id_alat_c2b','nama_alat_c2b','merk','ukuran','pabrikan','jumlah','rusak','lokasi_id'];
    protected $primaryKey = 'id_alat_c2b';
   public function lokasi()
   {
     return $this->belongsTo(Lokasi::class, 'lokasi_id','id_lokasi');
   }
}
