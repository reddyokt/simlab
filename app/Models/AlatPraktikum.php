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
        return $this->belongsTo(Kategorialat::class, 'id_kategori_alat', 'kategori_alat_id');
    }

}
