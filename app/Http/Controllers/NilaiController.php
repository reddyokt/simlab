<?php

namespace App\Http\Controllers;

use App\Models\JawabanTugas;
use App\Models\JawabanUjian;
use App\Models\Modul;
use App\Models\Nilai;
use App\Models\PraktikumMahasiswa;
use App\Models\Praktikum;
use App\Models\Mahasiswa;
use App\Models\PenilaianLisan;
use App\Models\PenilaianSubjektif;
use App\Models\Ujian;
use Illuminate\Http\Request;

class NilaiController extends Controller
{
    public function indexpenilaiantugas()
    {
        $data = Praktikum::whereHas('periode', function ($q1) {
            $q1->where('status_periode', 'Aktif');

        })
        ->get();

        return view('praktikan.nilai.indexpenilaiantugas', compact('data'));
    }

    public function isinilaitugasmahasiswa(Request $request)
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
        $subjektif = PenilaianSubjektif::where('modul_id', $mdl->id_modul)->where('mahasiswa_id',$mhs->id_mahasiswa)->first();
        $mhs_id = $request->mahasiswa_id;
        $modul_id = $request->modul_id;
        //dd ($pretest->toArray());
        return view ('praktikan.nilai.isinilaitugas',
        compact('mhs','mdl', 'pretest','posttest', 'laporan','jwbpretest','jwbposttest','jwblaporan','mhs_id','modul_id','subjektif'));
    }
    public function isinilaiujianmahasiswa(Request $request)
    {
        //dd($request->toArray());
        $mhs = Mahasiswa::find($request->mahasiswa_id);
        $praktikum = Praktikum::find($request->praktikum_id);
        $ujianawal = $praktikum->ujian->where('jenis_ujian','Ujian Awal')->first();
        $ujianakhir = $praktikum->ujian->where('jenis_ujian','Ujian Akhir')->first();
        $jwbujianawal = JawabanUjian::where('ujian_id',$ujianawal->id_ujian)->where('mahasiswa_id',$mhs->id_mahasiswa)->first();
        $jwbujianakhir = JawabanUjian::where('ujian_id',$ujianakhir->id_ujian)->where('mahasiswa_id',$mhs->id_mahasiswa)->first();
        $lisan = PenilaianLisan::where('praktikum_id', $praktikum->id_praktikum)->where('mahasiswa_id',$mhs->id_mahasiswa)->first();
        $mhs_id = $request->mahasiswa_id;
        $praktikum_id = $request->praktikum_id;

        return view ('praktikan.nilai.isinilaiujian',
        compact('mhs','praktikum','ujianawal', 'ujianakhir', 'jwbujianawal', 'jwbujianakhir', 'lisan', 'mhs_id', 'praktikum_id'));
    }
    public function storenilai1(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'nilai' => 'required|max:100|integer'],
        ['nilai.max'=>"Nilai Tidak Boleh Lebih Dari 100",
            'nilai.integer'=>"Nilai harus angka",
            'nilai.required'=>"Nilai harus diisi"
        ]);
        $nilai = JawabanTugas::where('tugas_id',$request->tugas_id)
            ->where('mahasiswa_id',$request->mahasiswa_id)
            ->update(['nilaitugas'=>$request->nilai, 'user_id'=>auth()->id()]
        );

        return redirect()->back();

    }

    public function storenilaiujian1(Request $request)
    {
        //dd($request->all());
        $request->validate([
            'nilai' => 'required|max:100|integer'],
        ['nilai.max'=>"Nilai Tidak Boleh Lebih Dari 100",
            'nilai.integer'=>"Nilai harus angka",
            'nilai.required'=>"Nilai harus diisi"
        ]);
        $nilai = JawabanUjian::where('ujian_id',$request->ujian_id)
            ->where('mahasiswa_id',$request->mahasiswa_id)
            ->update(['nilai_ujian'=>$request->nilai, 'user_id'=>auth()->id()]
        );

        return redirect()->back();
    }

    public function storenilai2(Request $request)
    {
         dd($request->all());
         $request->validate([
            'nilai' => 'required|max:100|integer'],
        ['nilai.max'=>"Nilai Tidak Boleh Lebih Dari 100",
            'nilai.integer'=>"Nilai harus angka",
            'nilai.required'=>"Nilai harus diisi"
        ]);
        $nilai = PenilaianSubjektif::updateOrCreate(
            ['mahasiswa_id'=>$request->mahasiswa_id, 'modul_id'=>$request->modul_id],
            ['nilaisubjektif'=>$request->nilai, 'user_id'=>auth()->id()]
        );
        return redirect()->back();
    }

    public function storenilaiujian2(Request $request)
    {
         //dd($request->all());
         $request->validate([
            'nilai' => 'required|max:100|integer'],
        ['nilai.max'=>"Nilai Tidak Boleh Lebih Dari 100",
            'nilai.integer'=>"Nilai harus angka",
            'nilai.required'=>"Nilai harus diisi"
        ]);
        $nilai = PenilaianLisan::updateOrCreate(
            ['mahasiswa_id'=>$request->mahasiswa_id, 'praktikum_id'=>$request->praktikum_id],
            ['nilai_ujian_lisan'=>$request->nilai, 'user_id'=>auth()->id()]
        );
        return redirect()->back();
    }

    public function isinilaitugas(Request $request)
    {
        //dd($request->all());
        $jawaban = JawabanTugas::find($request->id_jawaban_tugas);
        $jawaban->nilaitugas=$request->nilaitugas;
        $jawaban->save();

        return redirect ('/praktikan/nilaitugas')->with('success', 'Nilai berhasil ditambahkan');

    }

    public function indexpenilaianujian()
    {
        $data = Praktikum::whereHas('periode', function ($q1) {
            $q1->where('status_periode', 'Aktif');

        })
        ->get();
        return view('praktikan.nilai.indexpenilaianujian', compact('data'));
    }

    public function indexpenilaianakhir()
    {
        $data = Praktikum::whereHas('periode', function ($q1) {
            $q1->where('status_periode', 'Aktif');

        })
        ->get();

        return view('praktikan.nilai.indexpenilaianakhir', compact('data'));
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
