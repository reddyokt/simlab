<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CatatanModul extends Model
{
    use HasFactory;

    protected $table = 'catatan_modul';
    protected $primaryKey = 'id_catatan_modul';
    protected $fillable = ['modul_id','isi_catatan', 'user_id'];

    public function modul()
    {
        return $this->belongsTo(Modul::class,'modul_id', 'id_modul' );
    }
}
