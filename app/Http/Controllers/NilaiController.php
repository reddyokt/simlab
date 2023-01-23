<?php

namespace App\Http\Controllers;

use App\Models\JawabanTugas;
use App\Models\Modul;
use App\Models\Nilai;
use App\Models\PraktikumMahasiswa;
use App\Models\Praktikum;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function indexpenilaian()
    {
        $data = Praktikum::whereHas('periode', function ($q1) {
            $q1->where('status_periode', 'Aktif');

        })
        ->get();

        return view('praktikan.nilai.indexpenilaian', compact('data'));
    }

    public function isinilaimahasiswa(Request $request)
    {
        //dd($request->toArray());
        $mhs = Mahasiswa::find($request->mahasiswa_id);
        $mdl = Modul::find($request->modul_id);
        $pretest = $mdl->tugas->where('jenis_tugas','pretest')->first();
        $posttest = $mdl->tugas->where('jenis_tugas','posttest')->first();
        $laporan = $mdl->tugas->where('jenis_tugas','laporan')->first();
        $jwbpretest = JawabanTugas::where('tugas_id',$pretest->id_tugas)->where('mahasiswa_id',$mhs->id_mahasiswa)->first();
        $jwbposttest = JawabanTugas::where('tugas_id',$posttest->id_tugas)->where('mahasiswa_id',$mhs->id_mahasiswa)->first();
        $jwblaporan = JawabanTugas::where('tugas_id',$laporan->id_tugas)->where('mahasiswa_id',$mhs->id_mahasiswa)->first();
        $mhs_id = $request->mahasiswa_id;
        $modul_id = $request->modul_id;
        //dd ($pretest->toArray());
        return view ('praktikan.nilai.isinilai', compact('mhs','mdl', 'pretest','posttest', 'laporan','jwbpretest','jwbposttest','jwblaporan','mhs_id','modul_id'));
    }
    public function storenilai1(Request $request)
    {
        //dd($request->all());
        $nilai = JawabanTugas::where('tugas_id',$request->tugas_id)
        ->where('mahasiswa_id',$request->mahasiswa_id)
        ->update(['nilaitugas'=>$request->nilai]);

        return redirect()->route('isinilai');


    }
    public function indexnilaitugas()
    {
        // $data = JawabanTugas::whereHas('tugas', function ($q) {
        //     $q->whereHas('modul', function ($q2) {
        //         $q2->whereHas('praktikum', function ($q3) {
        //             $q3->whereHas('periode', function ($q4) {
        //                 $q4->where('status_periode', 'Aktif');
        //             });
        //         });
        //     });
        // }) ->get();
        // //dd($data->toArray());
        // return view('praktikan.nilai.indexnilaitugas', compact('data'));

    }
    public function isinilaitugas(Request $request)
    {
        //dd($request->all());

        $jawaban = JawabanTugas::find($request->id_jawaban_tugas);
        $jawaban->nilaitugas=$request->nilaitugas;
        $jawaban->save();

        return redirect ('/praktikan/nilaitugas')->with('success', 'Nilai berhasil ditambahkan');

    }

    public function indexnilaiakhir()
    {
        $data = JawabanTugas::whereHas('tugas', function ($q) {
            $q->whereHas('modul', function ($q2) {
                $q2->whereHas('praktikum', function ($q3) {
                    $q3->whereHas('periode', function ($q4) {
                        $q4->where('status_periode', 'Aktif');
                    });
                });
            });
        }) ->get();
        //dd($data->toArray());
        return view('praktikan.nilai.indexnilaitugas', compact('data'));
    }

    public function indexnilaisubjektif()
    {
        $data = JawabanTugas::whereHas('tugas', function ($q) {
            $q->whereHas('modul', function ($q2) {
                $q2->whereHas('praktikum', function ($q3) {
                    $q3->whereHas('periode', function ($q4) {
                        $q4->where('status_periode', 'Aktif');
                    });
                });
            });
        }) ->get();
        //dd($data->toArray());
        return view('praktikan.nilai.indexnilaitugas', compact('data'));
    }
}
