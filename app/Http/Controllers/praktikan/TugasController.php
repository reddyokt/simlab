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

        $modul=Modul::all();
        $tugas=DB::table('tugas')
        ->leftJoin('modul','modul.id_modul', '=' ,'tugas.modul_id')
        //->whereIn('tugas.is_validated',['Y'])
        ->get();
        return view ('praktikan.tugas.indextugas', compact ('tugas','modul'));
    }

    public function indexujian()
    {
        $kelas=Praktikum::all();
        $ujian=DB::table('ujian')
        ->leftJoin('praktikum','praktikum.id_praktikum', '=' ,'ujian.kelas_id')
        ->get();
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
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
        $kelas=Praktikum::all();
        return view ('praktikan.tugas.createujian', compact ('kelas'));
    }





    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
        //return $request;
        $ujian =  $request->validate([
            'id_kelas'  => 'required',
            'uraian_ujian' => 'required'
       ]);
       $ujian = new Ujian();
       $ujian->kelas_id= $request->id_kelas;
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

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tugas  $tugas
     * @return \Illuminate\Http\Response
     */
    public function show(Tugas $tugas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tugas  $tugas
     * @return \Illuminate\Http\Response
     */
    public function edit(Tugas $tugas)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tugas  $tugas
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tugas $tugas)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tugas  $tugas
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tugas $tugas)
    {
        //
    }
}
