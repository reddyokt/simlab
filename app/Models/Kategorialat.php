<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategorialat extends Model
{
    use HasFactory;

    protected $table = 'kategori_alat';
    protected $primaryKey = 'id_kategori_alat';
    protected $guarded = [];
}
