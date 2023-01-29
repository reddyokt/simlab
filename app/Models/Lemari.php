<?php

namespace App\Models;

use App\Models\Lokasi;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lemari extends Model
{
    use HasFactory;
   // protected $guarded = ['id_lemari'];
    protected $table = 'lemari';
    protected $fillable =['id_lemari','nama_lemari','id_lokasi'];
    protected $primaryKey = 'id_lemari';


    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'id_lokasi', 'id_lokasi');
    }
}
