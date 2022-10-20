<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Barang extends Model
{
    //use HasFactory;

    protected $table = 'barang';
    protected $fillable = ['id_barang', 'nama_barang', 'merk_barang','ukuran_barang',
                            'pabrik_barang', 'jumlah_barang','barang_rusak','lab','sub_lab'];
    protected $primaryKey = 'id_barang';

    public function lokasi()
    {
        return $this->belongsTo(Lokasi::class, 'lab', 'id_lokasi');
    }

    public function lokasi2()
    {
        return $this->belongsTo(Lokasi::class, 'sub_lab','id_lokasi');
    }
}
