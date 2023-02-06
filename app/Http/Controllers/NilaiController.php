<?php

namespace App\Http\Controllers;

use App\Models\JawabanTugas;
use App\Models\JawabanUjian;
use App\Models\Komposisinilai;
use App\Models\Modul;
use App\Models\Nilai;
use App\Models\PraktikumMahasiswa;
use App\Models\Praktikum;
use App\Models\Mahasiswa;
use App\Models\PenilaianLisan;
use App\Models\PenilaianSubjektif;
use App\Models\Ujian;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use PhpOffice\PhpSpreadsheet\Writer\Pdf as WriterPdf;

class NilaiController extends Controller
{
    public function indexpenilaiantugas()
    {
        $role = auth()->user()->role->role_name;
        $data = Praktikum::whereHas('periode', function ($q) use ($role) {
            if($role == 'Ka Unit'){
                $q = $q->where('dosen_id', auth()->user()->dosen->id_dosen);
            }
            if($role == 'Asisten Lab'){
                $q = $q->where('asisten_id', auth()->user()->id);
            }
            $q->where('status_periode', 'Aktif');

        })
        ->get();

        return view('praktikan.nilai.indexpenilaiantugas', compact('data'));
    }

    public function isinilaitugasmahasiswa(Request $request)
    {
        //dd($request->toArray());
        $mhs = Mahasiswa::find($request->mahasiswa_id);
        $mdl = Modul::find($request->modul_id);
        $pretest = $mdl->tugas->where('jenis_tugas','Pre Test')->first();
        $posttest = $mdl->tugas->where('jenis_tugas','Post Test')->first();
        $laporan = $mdl->tugas->where('jenis_tugas','Laporan')->first();
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
         //dd($request->all());
         $request->validate
        ([
            'nilai' => 'required|max:100|integer'
        ],
        [
            'nilai.max'=>"Nilai Tidak Boleh Lebih Dari 100",
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
        $role = auth()->user()->role->role_name;

        $data = Praktikum::whereHas('periode', function ($q) use($role) {
            if($role == 'Ka Unit'){
                $q = $q->where('dosen_id', auth()->user()->dosen->id_dosen);
            }
            if($role == 'Asisten Lab'){
                $q = $q->where('asisten_id', auth()->user()->id);
            }
            $q->where('status_periode', 'Aktif');

        })
        ->get();
        return view('praktikan.nilai.indexpenilaianujian', compact('data'));
    }

    public function indexpenilaianakhir()
    {
        $komPretest = Komposisinilai::where('nama_komponen', 'Nilai Pre Test')->first()->nilai_komponen;
        $komPosttest = Komposisinilai::where('nama_komponen', 'Nilai Post Test')->first()->nilai_komponen;
        $komSubjektif = Komposisinilai::where('nama_komponen', 'Nilai Subjektif')->first()->nilai_komponen;
        $komLaporan = Komposisinilai::where('nama_komponen', 'Nilai Laporan')->first()->nilai_komponen;
        $komUjiawal = Komposisinilai::where('nama_komponen', 'Nilai Ujian Awal')->first()->nilai_komponen;
        $komUjiakhir = Komposisinilai::where('nama_komponen', 'Nilai Ujian Akhir')->first()->nilai_komponen;
        $komUjilisan = Komposisinilai::where('nama_komponen', 'Nilai Ujian Lisan')->first()->nilai_komponen;


        $role = auth()->user()->role->role_name;
        $praktikum = Praktikum::whereHas('periode', function($q) use($role) {
            if($role == 'Ka Unit'){
                $q = $q->where('dosen_id', auth()->user()->dosen->id_dosen);
            }
            if($role == 'Asisten Lab'){
                $q = $q->where('asisten_id', auth()->user()->id);
            }
                    $q->where('status_periode', 'Aktif');
        })->get();

        $data = PraktikumMahasiswa::with(["mahasiswa","praktikum.kelas"])
                ->whereHas('praktikum', function($q) use($role) {
                    if($role == 'Ka Unit'){
                        $q = $q->where('dosen_id', auth()->user()->dosen->id_dosen);
                    }
                    if($role == 'Asisten Lab'){
                        $q = $q->where('asisten_id', auth()->user()->id);
                    }
                    $q->whereHas('periode', function ($q1){
                        $q1->where('status_periode', 'Aktif');
                });
        })->get();

        $data = json_encode($data->toArray());
        $data = json_decode($data);

        foreach ($data as $index=>$praktikum_mahasiswa){
            $mahasiswa_id = $praktikum_mahasiswa->mahasiswa_id;
            $praktikum_id = $praktikum_mahasiswa->praktikum_id;
            $jumlah_modul = $praktikum_mahasiswa->praktikum->kelas->jumlah_modul;

            $ujian_awal = JawabanUjian::whereHas('ujian', function ($q) use($praktikum_mahasiswa){
                            $q->where('praktikum_id',$praktikum_mahasiswa->praktikum_id)
                            ->where('jenis_ujian', 'Ujian Awal');
                        })
                        ->where('mahasiswa_id', $praktikum_mahasiswa->mahasiswa_id)
                        ->first();

            $ujian_akhir = JawabanUjian::whereHas('ujian', function ($q) use($praktikum_mahasiswa){
                            $q->where('praktikum_id',$praktikum_mahasiswa->praktikum_id)
                            ->where('jenis_ujian', 'Ujian Akhir');
                        })
                        ->where('mahasiswa_id', $praktikum_mahasiswa->mahasiswa_id)
                        ->first();

            $ujian_lisan = PenilaianLisan::where('praktikum_id',$praktikum_mahasiswa->praktikum_id)
                        ->where('mahasiswa_id', $praktikum_mahasiswa->mahasiswa_id)
                        ->first();

            $pretest = JawabanTugas::where('mahasiswa_id', $mahasiswa_id)
                        ->whereHas('tugas',function ($q) use($praktikum_id){
                            $q->where('jenis_tugas','Pre Test' )
                            ->whereHas('modul', function ($q1) use($praktikum_id){
                                $q1->where('praktikum_id', $praktikum_id);
                            });
                        })
                        ->get();

            $posttest = JawabanTugas::where('mahasiswa_id', $mahasiswa_id)
                        ->whereHas('tugas',function ($q) use($praktikum_id){
                            $q->where('jenis_tugas','Post Test' )
                            ->whereHas('modul', function ($q1) use($praktikum_id){
                                $q1->where('praktikum_id', $praktikum_id);
                            });
                        })
                        ->get();

            $laporan = JawabanTugas::where('mahasiswa_id', $mahasiswa_id)
                        ->whereHas('tugas',function ($q) use($praktikum_id){
                            $q->where('jenis_tugas','Laporan' )
                            ->whereHas('modul', function ($q1) use($praktikum_id){
                                $q1->where('praktikum_id', $praktikum_id);
                            });
                        })
                        ->get();

            $subjektif = PenilaianSubjektif::where('mahasiswa_id', $mahasiswa_id)
                        ->whereHas('modul', function ($q1) use($praktikum_id){
                            $q1->where('praktikum_id', $praktikum_id);
                        })->get();

            $data[$index]->ujian_awal = $ujian_awal;
            $data[$index]->ujian_akhir = $ujian_akhir;
            $data[$index]->ujian_lisan = $ujian_lisan;
            $data[$index]->pretest = $pretest;
            $data[$index]->posttest = $posttest;
            $data[$index]->laporan = $laporan;
            $data[$index]->subjektif = $subjektif;


            $totalujianawal = $ujian_awal->nilai_ujian ?? 0;
            $totalujianakhir = $ujian_akhir->nilai_ujian ?? 0;
            $totalujianlisan = $ujian_lisan->nilai_ujian_lisan ?? 0;

            $totalpretest = 0;
            $totalposttest = 0;
            $totalsubjektif = 0;
            $totallaporan = 0;

            foreach ($pretest as $x){
                $totalpretest = $totalpretest + $x->nilaitugas;
            }

            foreach ($posttest as $x){
                $totalposttest = $totalposttest + $x->nilaitugas;
            }

            foreach ($subjektif as $x){
                $totalsubjektif = $totalsubjektif + $x->nilaisubjektif;
            }

            foreach ($laporan as $x){
                $totallaporan = $totallaporan + $x->nilaitugas;
            }

            $pembagi = $jumlah_modul * 100;
            $nilaiakhir = (
                ($totalujianawal * $komUjiawal/100) +
                ($totalujianakhir * $komUjiakhir/100) +
                ($totalujianlisan * $komUjilisan/100) +
                ($totalpretest/$pembagi * $komPretest) +
                ($totalposttest/$pembagi * $komPosttest) +
                ($totalsubjektif/$pembagi * $komSubjektif) +
                ($totallaporan/$pembagi * $komLaporan)
            );

            $data[$index]->nilaiakhir = $nilaiakhir;

        }

        //dd($data);
        return view('praktikan.nilai.indexpenilaianakhir', compact('data','praktikum'));
    }

    public function exportnilaiakhir(Request $request)
    {
        //dd ($request->all());
       $praktikum = Praktikum::find($request->praktikum_id);
       $data = PraktikumMahasiswa::where('praktikum_id', $request->praktikum_id)
                ->with(["mahasiswa","praktikum.kelas"])
                ->whereHas('praktikum', function($q){
                    $q->whereHas('periode', function ($q1){
                        $q1->where('status_periode', 'Aktif');
                });
        })->get();

        $data = json_encode($data->toArray());
        $data = json_decode($data);

        foreach ($data as $index=>$praktikum_mahasiswa){
            $mahasiswa_id = $praktikum_mahasiswa->mahasiswa_id;
            $praktikum_id = $praktikum_mahasiswa->praktikum_id;
            $jumlah_modul = $praktikum_mahasiswa->praktikum->kelas->jumlah_modul;

            $ujian_awal = JawabanUjian::whereHas('ujian', function ($q) use($praktikum_mahasiswa){
                            $q->where('praktikum_id',$praktikum_mahasiswa->praktikum_id)
                            ->where('jenis_ujian', 'Ujian Awal');
                        })
                        ->where('mahasiswa_id', $praktikum_mahasiswa->mahasiswa_id)
                        ->first();

            $ujian_akhir = JawabanUjian::whereHas('ujian', function ($q) use($praktikum_mahasiswa){
                            $q->where('praktikum_id',$praktikum_mahasiswa->praktikum_id)
                            ->where('jenis_ujian', 'Ujian Akhir');
                        })
                        ->where('mahasiswa_id', $praktikum_mahasiswa->mahasiswa_id)
                        ->first();

            $ujian_lisan = PenilaianLisan::where('praktikum_id',$praktikum_mahasiswa->praktikum_id)
                        ->where('mahasiswa_id', $praktikum_mahasiswa->mahasiswa_id)
                        ->first();

            $pretest = JawabanTugas::where('mahasiswa_id', $mahasiswa_id)
                        ->whereHas('tugas',function ($q) use($praktikum_id){
                            $q->where('jenis_tugas','Pre Test' )
                                ->whereHas('modul', function ($q1) use($praktikum_id){
                                $q1->where('praktikum_id', $praktikum_id);
                            });
                        })->get();

            $posttest = JawabanTugas::where('mahasiswa_id', $mahasiswa_id)
                        ->whereHas('tugas',function ($q) use($praktikum_id){
                            $q->where('jenis_tugas','Post Test' )
                                ->whereHas('modul', function ($q1) use($praktikum_id){
                                $q1->where('praktikum_id', $praktikum_id);
                            });
                        })->get();

            $laporan = JawabanTugas::where('mahasiswa_id', $mahasiswa_id)
                        ->whereHas('tugas',function ($q) use($praktikum_id){
                            $q->where('jenis_tugas','Laporan' )
                                ->whereHas('modul', function ($q1) use($praktikum_id){
                                $q1->where('praktikum_id', $praktikum_id);
                            });
                        })->get();

            $subjektif = PenilaianSubjektif::where('mahasiswa_id', $mahasiswa_id)
                        ->whereHas('modul', function ($q1) use($praktikum_id){
                            $q1->where('praktikum_id', $praktikum_id);
                        })->get();

            $data[$index]->ujian_awal = $ujian_awal;
            $data[$index]->ujian_akhir = $ujian_akhir;
            $data[$index]->ujian_lisan = $ujian_lisan;
            $data[$index]->pretest = $pretest;
            $data[$index]->posttest = $posttest;
            $data[$index]->laporan = $laporan;
            $data[$index]->subjektif = $subjektif;


            $totalujianawal = $ujian_awal->nilai_ujian ?? 0;
            $totalujianakhir = $ujian_akhir->nilai_ujian ?? 0;
            $totalujianlisan = $ujian_lisan->nilai_ujian_lisan ?? 0;

            $totalpretest = 0;
            $totalposttest = 0;
            $totalsubjektif = 0;
            $totallaporan = 0;

            foreach ($pretest as $x){
                $totalpretest = $totalpretest + $x->nilaitugas;
            }

            foreach ($posttest as $x){
                $totalposttest = $totalposttest + $x->nilaitugas;
            }

            foreach ($subjektif as $x){
                $totalsubjektif = $totalsubjektif + $x->nilaisubjektif;
            }

            foreach ($laporan as $x){
                $totallaporan = $totallaporan + $x->nilaitugas;
            }

            $pembagi = $jumlah_modul * 100;
            $nilaiakhir = (
                ($totalujianawal * 10/100) +
                ($totalujianakhir * 10/100) +
                ($totalujianlisan * 10/100) +
                ($totalpretest/$pembagi * 5) +
                ($totalposttest/$pembagi * 5) +
                ($totalsubjektif/$pembagi * 40) +
                ($totallaporan/$pembagi *20)
            );

            $data[$index]->nilaiakhir = $nilaiakhir;
        }

        $pdf = Pdf::loadView('pdf.exportnilaiakhir', compact ('data','praktikum'));
        return $pdf->stream();

        //dd($data);

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
