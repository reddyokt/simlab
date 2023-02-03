<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use App\Models\Daftar;
use App\Models\Mahasiswa;
use App\Models\NewMahasiswa;
use App\Models\Praktikum;
use App\Models\PraktikumMahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use League\CommonMark\Inline\Parser\NewlineParser;
use App\Models\Periode;
use Illuminate\Support\Carbon;
use App\Models\Modul;
use App\Models\Ujian;

class DashboardController extends BaseController
{
    public function index ()
    {
        $periode = Periode::where('status_periode', 'Aktif')->first();
        $data = Praktikum::whereHas('periode', function($q){
            $q->where('status_periode','Aktif');
        })->get();

        $datamhs = PraktikumMahasiswa::whereHas('praktikum', function($q){
            $q->whereHas('periode', function($q1){
                $q1->where('status_periode', 'Aktif');
            });
        })->count();
        $kelas = Praktikum::all();
        $now = Carbon::now()->toDateString();

        $ujian = Ujian::whereHas('praktikum',function ($q){
            $q->whereHas('periode', function ($q2){
                $q2->where('status_periode','Aktif');
            });
        })->where('is_active','Y')
        ->get();
        $tugas = Modul::whereHas('praktikum',function ($q){
            $q->whereHas('periode', function ($q2){
                $q2->where('status_periode','Aktif');
            });
        })->whereHas('tugas', function($r){
            $r->where('is_active', 'Y');
        })
        ->get();


        $jwbtugas= NewMahasiswa::where('user_id',auth()->id())
        ->first();
        //dd($jwbtugas->toArray());
        return view ('dashboard.index',compact('data','datamhs','periode', 'ujian','tugas','kelas','jwbtugas'));
    }
}
