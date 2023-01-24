<?php

namespace App\Http\Controllers\praktikan;

use App\Models\Modul;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Praktikum;
use App\Models\Ujian;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\AssignOp\Mod;
use Symfony\Component\CssSelector\XPath\Extension\FunctionExtension;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indextugas()
    {


        $data = Tugas::whereHas('modul', function ($q){
            $q->whereHas('praktikum', function ($q2){
                $q2->whereHas('periode',function ($q3){
                    $q3->where('status_periode', 'Aktif');
                });
            });
        })
        ->get();
        //dd($data->toArray());
        return view ('praktikan.tugas.indextugas', compact ('data'));
    }

    public function indexujian()
    {
        $ujian = Ujian::whereHas('praktikum', function($q){
            $q->whereHas('periode', function($q1){
                $q1->where('status_periode','Aktif');
            });
        })->get();
        //dd($ujian->toArray());
        return view ('praktikan.tugas.indexujian', compact ('ujian'));
    }

    public function validasi()
    {
        $modul=Modul::all();
        $tugas=DB::table('tugas')
        ->leftJoin('modul','modul.id_modul', '=' ,'tugas.modul_id')
        ->get();
        return view ('praktikan.tugas.validasi', compact ('tugas','modul'));
    }
    public function validasitugas($id_tugas)
    {
        //dd($id_tugas);
        $validasitugas = Tugas::find($id_tugas);
        $validasitugas->update(['is_validated'=>'Y']);
        //$validasitugas->updated_by = Auth::user()->id;

        return redirect ('/praktikan/validasi')->with('success', 'Tugas berhasil divalidasi');
    }


    public function createtugas()
    {
        $modul=Modul::all();
        $tugas=DB::table('tugas')
        ->leftJoin('modul','modul.id_modul', '=' ,'tugas.modul_id')
        ->get();
        return view ('praktikan.tugas.createtugas', compact ('tugas','modul'));
    }

    public function createujian()
    {
       $data = Praktikum::whereHas('periode', function ($q){
        $q->where('status_periode','Aktif');
       })
       ->get();
        return view ('praktikan.tugas.createujian', compact ('data'));
    }


    public function storetugas(Request $request)
    {
        //return $request;
        $tugas =  $request->validate([
            'id_modul'  => 'required',
            'jenis_tugas' => 'required',
            'uraian_tugas'=> 'required'
       ]);
       $tugas = new Tugas();
       $tugas->modul_id= $request->id_modul;
       $tugas->jenis_tugas= $request->jenis_tugas;
       $tugas->uraian_tugas= $request->uraian_tugas;

       $tugas->save();
       return redirect('/praktikan/tugas')->with('success', 'Tugas berhasil ditambahkan - Menunggu Validasi Dosen');
    }

    public function storeujian(Request $request)
    {
        //dd ($request->toArray());
        $ujian =  $request->validate([
            'praktikum_id'  => 'required',
            'jenis_ujian' =>'required|in:Ujian Awal,Ujian Akhir',
            'uraian_ujian' => 'required',
            'soal_ujian' => 'nullable|mimes:png,jpg,pdf|max:2048'
       ]);
       if($request->file('soal_ujian')) {
            $ujian['soal_ujian'] = $request->file('soal_ujian')->store('soal_ujian');
        }
        $ujian['user_id'] = auth()->id();
        Ujian::create($ujian);

        return redirect('/praktikan/ujian');
    }

    public function showtugas($id_tugas)
    {
        //dd($id_tugas);
        $showtugas = Tugas::find($id_tugas);
        $showtugas->update(['is_active'=>'Y']);

        return redirect ('/praktikan/tugas')->with('success', 'Tugas berhasil dimunculkan di landing page');
    }

    public function hidetugas($id_tugas)
    {
        //dd($id_tugas);
        $hidetugas = Tugas::find($id_tugas);
        $hidetugas->update(['is_active'=>'N']);

        return redirect ('/praktikan/tugas')->with('success', 'Tugas berhasil disembunyikan di landing page');
    }

    public function showujian($id_ujian)
    {
        //dd($id_tugas);
        $showujian = Ujian::find($id_ujian);
        $showujian->update(['is_active'=>'Y']);

        return redirect ('/praktikan/ujian')->with('success', 'Ujian berhasil dimunculkan di landing page');
    }

    public function hideujian($id_ujian)
    {
        //dd($id_tugas);
        $hideujian = Ujian::find($id_ujian);
        $hideujian->update(['is_active'=>'N']);

        return redirect ('/praktikan/ujian')->with('success', 'Ujian berhasil disembunyikan di landing page');
    }

}
