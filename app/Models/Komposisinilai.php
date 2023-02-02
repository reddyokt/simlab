<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Komposisinilai extends Model
{
    use HasFactory;

    protected $table = 'komposisi_nilai';
    protected $primaryKey = 'id_komposisi_nilai';
    protected $guarded = [];
}
