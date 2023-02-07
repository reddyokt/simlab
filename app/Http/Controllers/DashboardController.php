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
use App\Models\PenilaianLisan;
use App\Models\Tugas;
use App\Models\Ujian;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\PenilaianSubjektif;

class DashboardController extends BaseController
{
    public function index ()
    {
        $periode = Periode::where('status_periode', 'Aktif')->first();
        $data = Praktikum::whereHas('periode', function($q){
            $q->where('status_periode','Aktif');
        })->get();
        $role = auth()->user()->role->role_name;

        $mahasiswa = NewMahasiswa::where('user_id', auth()->user()->id)->first();
        
        $pretest = PraktikumMahasiswa::where('mahasiswa_id', $mahasiswa->id_mahasiswa)
        ->whereHas('praktikum', function ($q){
            $q->where('id_praktikum', 'praktikummhs.praktikum_id')
                ->whereHas('modul', function($q1){
                    $q1->whereHas('tugas', function($q2){
                        $q2->where('jenis_tugas', 'Pre Test');
                    });
                });
            })
            ->first();

        dd($pretest);

        // $datamhs = PraktikumMahasiswa::whereHas('praktikum', function($q){
        //     $q->where('ujian', )
        //     ->whereHas('periode', function($q1){
        //         $q1->where('status_periode', 'Aktif');
        //     });
        // })->get();

        // if($role=='Mahasiswa')
        // $mahasiswa = NewMahasiswa::where('user_id', auth()->id())->first();
        // $datamhs = Tugas::where('');

        // $kelas = Praktikum::all();
        // $now = Carbon::now()->toDateString();

        // $ujian = Ujian::whereHas('praktikum',function ($q){
        //     $q->whereHas('periode', function ($q2){
        //         $q2->where('status_periode','Aktif');
        //     });
        // })->where('is_active','Y')
        // ->get();

        // // $tugas = Tugas::whereHas('modul', function ($q){
        // //     $q->whereHas('praktikum', function ($q1){
        // //         $q1->whereHas('periode', function ($q2){
        // //             $q2->where('status_periode', 'Aktif');
        // //         });
        // //     });
        // // })->where('is_active', 'Y')->first();


        $jwbtugas= NewMahasiswa::where('user_id',auth()->id())
        ->first();
        //dd($jwbtugas->toArray());

        $role=auth()->user()->role->role_name;

        $tugas = PraktikumMahasiswa::whereHas('praktikum', function ($q) use($role){
            if($role=='Mahasiswa'){
                {
                    $q = $q->where('mahasiswa_id', auth()->user()->mahasiswa->id_mahasiswa);
                }
            }
            $q->whereHas('periode', function ($q1) use($role){
                $q1->where('status_periode', 'Aktif');
            });
        })->get();

        return view ('dashboard.index',compact('data','datamhs','periode', 'ujian','kelas','jwbtugas','tugas'));
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

        // $jwbtugas = JawabanTugas::with(["tugas.modul"])->whereHas('tugas', function ($q) use($data){
        //     $q->whereHas('modul', function ($q1) use($data){
        //         $q1->whereHas('praktikum', function ($q2) use($data){
        //             $q2->where('id_praktikum', $data->praktikum_id);
        //         });
        //     });
        // })->where('mahasiswa_id', $data->mahasiswa_id)->get();

        $ujianawal = JawabanUjian::whereHas('ujian', function ($q) use($data){
            $q->where("jenis_ujian", 'Ujian Awal')
            ->whereHas('praktikum', function ($q1) use($data){
                $q1->where('id_praktikum' , $data->praktikum_id);
            });
        })->where('mahasiswa_id', $data->mahasiswa_id)->first();
        if($ujianawal){
            $ujianawal = $ujianawal->nilai_ujian;
        }

        $ujiakhir = JawabanUjian::whereHas('ujian', function ($q) use($data){
            $q->where("jenis_ujian", 'Ujian Akhir')
            ->whereHas('praktikum', function ($q1) use($data){
                $q1->where('id_praktikum' , $data->praktikum_id);
            });
        })->where('mahasiswa_id', $data->mahasiswa_id)->first();
        if($ujiakhir){
            $ujiakhir = $ujiakhir->nilai_ujian;
        }

        $ujianlisan = PenilaianLisan::whereHas('praktikum', function ($q) use($data){
            $q->where('id_praktikum', $data->praktikum_id);
        })->where('mahasiswa_id', $data->mahasiswa_id)->first();
        if($ujianlisan){
            $ujianlisan = $ujianlisan->nilai_ujian_lisan;
        }
        //dd($ujianawal);
        $data1 = PraktikumMahasiswa::where('mahasiswa_id', auth()->user()->mahasiswa->id_mahasiswa)
            ->where('praktikum_id', $request->praktikum_id)
                ->with(["mahasiswa","praktikum.kelas"])
                ->whereHas('praktikum', function($q){
                    $q->whereHas('periode', function ($q1){
                        $q1->where('status_periode', 'Aktif');
                });
        })->get();

        $data1 = json_encode($data1->toArray());
        $data1 = json_decode($data1);

        foreach ($data1 as $index=>$praktikum_mahasiswa){
            $mahasiswa_id = $praktikum_mahasiswa->mahasiswa_id;
            $praktikum_id = $praktikum_mahasiswa->praktikum_id;
            $jumlah_modul = $praktikum_mahasiswa->praktikum->kelas->jumlah_modul;

            //dd($jumlah_modul);

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

            $data1[$index]->ujian_awal = $ujian_awal;
            $data1[$index]->ujian_akhir = $ujian_akhir;
            $data1[$index]->ujian_lisan = $ujian_lisan;
            $data1[$index]->pretest = $pretest;
            $data1[$index]->posttest = $posttest;
            $data1[$index]->laporan = $laporan;
            $data1[$index]->subjektif = $subjektif;


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

            $data1[$index]->nilaiakhir = $nilaiakhir;
        }
        $nilaiakhir = $data1[0]->nilaiakhir;


        $pdf = Pdf::loadView('pdf.exportnilaimhs', compact ('data','praktikum','ujiakhir','ujianawal','ujianlisan','nilaiakhir'));
        return $pdf->stream();
    }


}
