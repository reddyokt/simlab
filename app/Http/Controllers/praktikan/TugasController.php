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
        $ujian = Ujian::all();
        //dd($ujian->all());
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
        $praktikum=DB::table('praktikum')
        ->leftJoin('kelas','praktikum.kelas_id', '=' ,'kelas.id_kelas')
        ->where('praktikum.is_active','Y')
        ->get();

        //dd($praktikum->toArray());
        return view ('praktikan.tugas.createujian', compact ('praktikum'));
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
            'uraian_ujian' => 'required'
       ]);
       $ujian = new Ujian();
       $ujian->praktikum_id= $request->praktikum_id;
       $ujian->uraian_ujian= $request->uraian_ujian;

       $ujian->save();
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
