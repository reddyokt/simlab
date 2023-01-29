<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewMahasiswa extends Model
{
    use HasFactory;

    protected $table ='new_mahasiswa';
    protected $primaryKey = 'id_mahasiswa';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function praktikumMhs()
    {
        return $this->belongsToMany(PraktikumMahasiswa::class, 'praktikum_mahasiswa', 'praktikum_id','mahasiswa_id','id_praktikum', 'id_mahasiswa');
    }
}

