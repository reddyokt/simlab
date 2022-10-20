<?php

namespace App\Http\Controllers\praktikan;

use App\Models\Modul;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use PhpParser\Node\Expr\AssignOp\Mod;

class TugasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modul=Modul::all();
        $tugas=DB::table('tugas')
        ->leftJoin('modul','modul.id_modul', '=' ,'tugas.modul_id')
        ->get();
        return view ('praktikan.tugas.index', compact ('tugas','modul'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
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
       $tugas->uraian= $request->uraian_tugas;

       $tugas->save();
       return redirect('/praktikan/tugas');
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
