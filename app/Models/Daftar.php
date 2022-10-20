<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Daftar extends Model
{
    use HasFactory;

    protected $table='pendaftaran';
    protected $fillable= ['id_pendaftaran', 'mahasiswa_id', 'email', 'phone', 'status','created_by'];
    protected $primaryKey = 'id_pendaftaran';
    protected $status =['Diterima', 'Ditolak'];

    public function pendaftar()
    {
        return $this->belongsTo(Mahasiswa:: class,  'mahasiswa_id', 'id_mahasiswa');
    }
}
