<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Daftar;
use App\Models\Mahasiswa;
use App\Models\Praktikum;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends BaseController
{
    public function index ()
    {
            $dataMhs = DB::table('mahasiswa')
            ->join('pendaftaran','pendaftaran.mahasiswa_id','=','mahasiswa.id_mahasiswa')
            ->join('praktikum','praktikum.id_praktikum','=','pendaftaran.kelas_id')
            ->whereIn('pendaftaran.status',['Belum divalidasi'])
            ->get();


            return view ('dashboard.index', compact('dataMhs'));
    }
}
