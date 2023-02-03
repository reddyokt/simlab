<?php

namespace App\Http\Controllers;

use App\Models\Absen;
use Illuminate\Routing\Controller as BaseController;
use App\Models\Daftar;
use App\Models\JawabanTugas;
use App\Models\JawabanUjian;
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
use App\Models\Tugas;
use App\Models\Ujian;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function absensimhs(Request $request)
    {
        $data = PraktikumMahasiswa::where('mahasiswa_id', auth()->user()->mahasiswa->id_mahasiswa)
                        ->where('praktikum_id', $request->praktikum_id)
                            ->first();
        if( !$data )
            return redirect()->back()->withErrors('Kamu tidak mengikuti Kelas tersebut.');
        //dd($data);
        $praktikum = Praktikum::find($data->praktikum_id);
        $absen = Absen::whereHas('modul', function ($q) use($data) {
            $q->whereHas('praktikum', function ($q1) use($data){
                $q1->where('id_praktikum', $data->praktikum_id);
            });
        })->where('mahasiswa_id', $data->mahasiswa_id)->get();



        $pdf = Pdf::loadView('pdf.exportrekapabsen', compact ('data','absen','praktikum'));
        return $pdf->stream();
    }

    public function nilaimhs(Request $request)
    {
        $data = PraktikumMahasiswa::where('mahasiswa_id', auth()->user()->mahasiswa->id_mahasiswa)
                        ->where('praktikum_id', $request->praktikum_id)
                            ->first();
        //dd($data->toArray());
        if( !$data )
            return redirect()->back()->withErrors('Kamu tidak mengikuti Kelas tersebut.');
        $praktikum = Praktikum::find($data->praktikum_id);

        $jwbtugas = JawabanTugas::with(["tugas.modul"])->whereHas('tugas', function ($q) use($data){
            $q->whereHas('modul', function ($q1) use($data){
                $q1->whereHas('praktikum', function ($q2) use($data){
                    $q2->where('id_praktikum', $data->praktikum_id);
                });
            });
        })->where('mahasiswa_id', $data->mahasiswa_id)->get();

        $jwbujian = JawabanUjian::whereHas('ujian', function ($q) use($data){
            $q->whereHas('praktikum', function ($q1) use($data){
                $q1->where('id_praktikum' , $data->praktikum_id);
            });
        })->where('mahasiswa_id', $data->mahasiswa_id)->get();

        //dd($jwbtugas->toArray(), $jwbujian->toArray());

        $pdf = Pdf::loadView('pdf.exportnilaimhs', compact ('data','praktikum','jwbtugas','jwbujian'));
        return $pdf->stream();
    }


}
